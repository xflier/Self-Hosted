# -*- coding: utf-8 -*-
SECRET_KEY = "replace-with-your-generated-secret-key"

TIME_ZONE = 'America/New_York'

ENABLE_ONLYOFFICE = True
VERIFY_ONLYOFFICE_CERTIFICATE = False
ONLYOFFICE_FORCE_SAVE = True
ONLYOFFICE_INTERNAL_URL = 'http://onlyoffice/'
ONLYOFFICE_APIJS_URL = 'https://onlyoffice.self.test/web-apps/apps/api/documents/api.js'
ONLYOFFICE_FILE_EXTENSION = ('doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'fodt', 'odp', 'fodp', 'ods', 'fods', 'csv', 'ppsx', 'pps')
ONLYOFFICE_EDIT_FILE_EXTENSION = ('docx', 'pptx', 'xlsx')
ONLYOFFICE_JWT_SECRET = 'replace-with-your-jwt-secret'
OFFICE_PREVIEW_MAX_SIZE = 30 * 1024 * 1024
