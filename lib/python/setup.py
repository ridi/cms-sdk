"""A setuptools based setup module.
"""

from setuptools import setup, find_packages

setup(
    name='cmssdk',
    packages=[
        'cmssdk',
        'cmssdk.AdminAuth',
        'cmssdk.AdminMenu',
        'cmssdk.AdminTag',
        'cmssdk.AdminUser',
        'cmssdk.Errors',
    ],
    version='0.6.6',
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
    ],
)
