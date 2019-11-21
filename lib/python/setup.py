"""A setuptools based setup module.
"""

from setuptools import setup, find_packages

setup(
    name='ridi-cms-sdk',
    packages=[
        'ridi.cms',
        'ridi.cms.thrift.AdminAuth',
        'ridi.cms.thrift.AdminMenu',
        'ridi.cms.thrift.AdminTag',
        'ridi.cms.thrift.AdminUser',
        'ridi.cms.thrift.Errors',
    ],
    version='3.0.0rc5',
    description='Ridi CMS SDK',
    url='https://github.com/ridi/cms-sdk',
    keywords=['cmssdk', 'ridi', 'ridibooks'],
    classifiers=[
        'License :: OSI Approved :: MIT License',
        'Programming Language :: Python :: 3',
    ],
    install_requires=[
        'thrift>=0.10.0',
        'requests>=2.0.0',
        'pyjwt>=1.7.1',
        'cryptography>=2.7',
    ],
)
