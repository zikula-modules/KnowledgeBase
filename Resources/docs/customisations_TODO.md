

CUSTOMISATIONS
--------------

Knowledge Base - Manual additions and amendments

Changed files:
  * style/style.css
  * templates/user/footer.tpl
  * templates/user/header.tpl
  * templates/user/main.tpl
  * templates/user/ticket/display.tpl
  * templates/user/ticket/edit.tpl
  * templates/user/ticket/view.tpl

Implemented classes:
  * lib/KnowledgeBase/Installer.php
  * lib/KnowledgeBase/Api/Search.php
  * lib/KnowledgeBase/Api/User.php
  * lib/KnowledgeBase/Controller/Ajax.php
  * lib/KnowledgeBase/Controller/Base/User.php (small hack in display function for manual API call to increment view counter)
  * lib/KnowledgeBase/Controller/User.php
  * lib/KnowledgeBase/Entity/Repository/Ticket.php

Additional files:
  * javascript/KnowledgeBase.js
  * lib/KnowledgeBase/Api/Manual.php
  * templates/user/include/*
  * templates/knowledgebase_search_options.tpl
