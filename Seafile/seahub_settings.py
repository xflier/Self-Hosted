# -*- coding: utf-8 -*-
SECRET_KEY = "ds=rc5n%6p56j#=#8-v9g)0!r1hqh5d-4fd*uj09tdlhm*xvg8"

TIME_ZONE = '<defined in .env>'

ENABLE_ONLYOFFICE = True
VERIFY_ONLYOFFICE_CERTIFICATE = False
ONLYOFFICE_FORCE_SAVE = True
ONLYOFFICE_INTERNAL_URL = 'http://onlyoffice/'
ONLYOFFICE_APIJS_URL = 'https://<onlyoffice domain in .env>/web-apps/apps/api/documents/api.js'
ONLYOFFICE_FILE_EXTENSION = ('doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'fodt', 'odp', 'fodp', 'ods', 'fods', 'csv', 'ppsx', 'pps')
ONLYOFFICE_EDIT_FILE_EXTENSION = ('docx', 'pptx', 'xlsx')
ONLYOFFICE_JWT_SECRET = 'JWT_PRIVATE_KEY in .env'
