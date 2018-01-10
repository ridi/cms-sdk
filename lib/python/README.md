# Ridibooks CMS SDK - Python

## Install
```sh
pip install ridi
```

## Hierarchy
```
    ...
```

## Usage
```python
from CmsClient import CmsClient

client = CmsClient('http://localhost:8000')
user = client.adminUser.getUser('admin')
print(user)
```
