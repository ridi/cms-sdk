#!/bin/bash

# Monitor mode (used to attach into couchbase entrypoint)
set -m
# Send it to background
/entrypoint.sh couchbase-server &

# Check if couchbase server is up
check_db() {
  curl --silent http://127.0.0.1:8091/pools > /dev/null
  echo $?
}

# Variable used in echo
i=1
# Echo with
numbered_echo() {
  echo "[$i] $@"
  i=`expr $i + 1`
}

# Parse JSON and get nodes from the cluster
read_nodes() {
  cmd="import sys,json;"
  cmd="${cmd} print(','.join([node['otpNode']"
  cmd="${cmd} for node in json.load(sys.stdin)['nodes']"
  cmd="${cmd} ]))"
  python -c "${cmd}"
}

# Wait until it's ready
until [[ $(check_db) = 0 ]]; do
  >&2 numbered_echo "Waiting for Couchbase Server to be available"
  sleep 1
done

echo "# Couchbase Server Online"

echo "# Check initialized"
couchbase-cli server-list -c 127.0.0.1:8091 -u ridibooks -p ridibooks > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "# Init Cluster"
    couchbase-cli cluster-init \
      --cluster-username=ridibooks \
      --cluster-password=ridibooks \
      --services=data \
      --cluster-ramsize=256 \
      --index-storage-setting=default

    echo "# Session Bucket create"
    couchbase-cli bucket-create -c 127.0.0.1:8091 \
           --bucket=session \
           --bucket-type=couchbase \
           --bucket-ramsize=100 \
           -u ridibooks -p ridibooks
fi

# Attach to couchbase entrypoint
numbered_echo "Attaching to couchbase-server entrypoint"
fg 1
