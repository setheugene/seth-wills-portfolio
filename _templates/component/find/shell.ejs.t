---
sh: 'rsync -r --exclude previews/ llcl@llcl.ssh.wpengine.net:/sites/llcl/wp-content/themes/component-library/components/<%= h.changeCase.paramCase(component) %> components && scp -O llcl@llcl.ssh.wpengine.net:/sites/llcl/wp-content/themes/component-library/acf-json/<%=acfGroup%>.json acf-json'
---