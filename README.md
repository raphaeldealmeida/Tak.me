Tak.me
======

Encurtador de URL desenvolvido durante o [Workshop PHP eXtreme 5.3](http://www.schoolofnet.com/phpextreme53/)

Instalação
----------
`$ pear install vendor/Image_QRCode-0.1.3.tgz`

Importar SLQ para o banco shorten

Configurar um vhost no apache,
tome cuidado para alterar os as pastas 

Linux
-----
incluir arquivo 
/etc/apache2/sites-enabled/tak.me.local
com o seguinte conteúdo:

`<VirtualHost *:80>
   DocumentRoot "/var/www/Tak.me/public"
   ServerName Tak.me.local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/var/www/Tak.me/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>`

Windows
-------
wamp - http://gilbertoalbino.com/adicionar-virtual-host-no-windows-com-wamp/
xamp - http://www.codigosnaweb.com/forum/Criando-um-virtual-host-no-Xampp_26_3538.html

Incluir seguinte linha no arquivo
`/etc/hosts (linux)
c:\windows\system32\drivers\etc\hosts (windows)
127.0.0.1       Tak.me.local`


TODO
----
1. Criar uma tela de erros, não esqueça de mudar o código http para 404, 500 etc
2. Tratar url duplicada
3. Tratar shorten inválido
4. Url original na página shorten
5. Número de visitas
6. Melhorar algorítimo de encurtamento