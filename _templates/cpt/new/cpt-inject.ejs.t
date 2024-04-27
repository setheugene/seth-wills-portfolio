---
inject: true
to: lib/cpt/main.php
append: true,
---
require_once( plugin_dir_path( __FILE__ ) . 'cpt-<%=h.changeCase.snakeCase(name)%>.php' );