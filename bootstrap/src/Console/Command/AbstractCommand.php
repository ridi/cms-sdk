<?php

namespace Ridibooks\Cms\Console\Command;

use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    protected $package_dir;
    protected $bootstrap_dir;
    protected $project_dir;
    protected $docker_config;
    protected $haproxy_config;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->package_dir = realpath(__DIR__ . '/../../../..');

        // Check stand-alone package,
        if (file_exists($this->package_dir . '/vendor/autoload.php')) {
            $this->project_dir = $this->package_dir;
        } else {
            $this->project_dir = realpath($this->package_dir . '/../../..');
        }

        $this->bootstrap_dir = $this->package_dir . '/bootstrap';
        $this->docker_config = $this->bootstrap_dir . '/docker-compose.yml';
        $this->haproxy_config = $this->bootstrap_dir . '/service/haproxy/config/haproxy.cfg';
    }

    protected function getServices()
    {
        $result = shell_exec('sed -n "/CUSTOM SERVICES START/,/CUSTOM SERVICES END/p" ' . $this->docker_config . ' | sed -n "/^[[:space:]][[:space:]][a-zA-Z0-9\-]*:$/p"');
        if (empty($result)) {
            return [];
        }

        $result = str_replace(' ', '', $result);
        $result = str_replace(':', '', $result);
        return explode("\n", trim($result));
    }

    protected function getServiceDir($service)
    {
        $parsed = shell_exec('sed -n "/' . $service . ':/{N;N;N;p;}" ' . $this->docker_config . ' | sed -n "s/- \(.*\):\/var\/www\/html$/\1/p" | sed "s/[[:space:]]//g"');
        $trimmed = trim($parsed);
        if ($trimmed[0] === DIRECTORY_SEPARATOR) {
            return $trimmed;
        }

        return realpath("$this->bootstrap_dir/$trimmed");
    }

    protected function addService($service, $path, $dir)
    {
        shell_exec("cp $this->docker_config $this->docker_config.bak");
        $create_service_cmd = "sed -e 's|{SERVICE_NAME}|$service|g' -e 's|{SERVICE_DIR}|$dir|g' $this->bootstrap_dir/template/docker-compose-service.tpl";
        $append_service_cmd = "sed $'/CUSTOM SERVICES START/r/dev/stdin' $this->docker_config.bak";
        shell_exec("$create_service_cmd | $append_service_cmd > $this->docker_config");

        shell_exec("cp $this->haproxy_config $this->haproxy_config.bak");
        $create_acl_cmd = "sed -e 's|{SERVICE_NAME}|$service|g' -e 's|{SUB_PATH}|$path|g' $this->bootstrap_dir/template/haproxy-acl.tpl";
        $append_acl_cmd = "sed $'/ACL LIST/r/dev/stdin' $this->haproxy_config.bak";
        shell_exec($create_acl_cmd . ' | ' . $append_acl_cmd . ' > ' . "$this->haproxy_config.tmp");
        $create_backend_cmd = "sed 's|{SERVICE_NAME}|$service|g' $this->bootstrap_dir/template/haproxy-backend.tpl";
        $append_backend_cmd = "sed $'/BACKEND LIST/r/dev/stdin' $this->haproxy_config.tmp";
        shell_exec("$create_backend_cmd | $append_backend_cmd > $this->haproxy_config ; rm $this->haproxy_config.tmp");

        shell_exec("mkdir -p $dir");
    }

    protected function removeService($service)
    {
        shell_exec("cp $this->haproxy_config $this->haproxy_config.bak");
        shell_exec("sed -e '/acl is_$service/{N;d;}' -e '/backend $service/{N;N;d;}' $this->haproxy_config.bak > $this->haproxy_config");
        shell_exec("cp $this->docker_config $this->docker_config.bak");
        shell_exec("sed '/$service:/{N;N;N;N;N;N;N;N;N;N;N;N;d;}' $this->docker_config.bak > $this->docker_config");
    }
}
