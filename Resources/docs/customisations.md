

CUSTOMISATIONS
--------------

Knowledge Base - Manual additions and amendments

Changed files:
 * Controller/Base/UserController.php (small hack in display function for manual API call to increment view counter)
 * Resources/public/css/style.css
 * Resources/views/User/footer.tpl
 * Resources/views/User/header.tpl
 * Resources/views/User/Ticket/display.tpl
 * Resources/views/User/Ticket/edit.tpl
 * Resources/views/User/Ticket/view.tpl

Implemented classes:
 * Api/UserApi.php
 * Controller/AjaxController.php
 * Controller/UserController.php
 * Entity/Repository/Ticket.php
 * KnowledgeBaseModuleInstaller.php

Additional files:
 * Resources/public/js/GuiteKnowledgeBaseModule_frontend.js
 * Api/ManualApi.php
 * Resources/views/plugins/function.kbbreadcrumb.php
 * Resources/views/plugins/function.kbProcessListLevels.php
 * Resources/views/User/Include/*
 * Resources/views/User/index.tpl
