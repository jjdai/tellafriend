README FIRST
-----------------------

[mlimg]
[xlang:en]

= Tell a Friend =
It is hard to use the link for "Tell a friend" with multi-byte languages.
Even with sigle-byte language, "mailto:" is not useful in the environments without MUA. eg) Internet Cafe
Thus I've made a module of Form Mail working with a Smarty plugin collaboratively.
After you install this, a visitor can send e-mails to his friends by Form mail when he just click the icon.

USAGE:

- Install this module as usual.
- Check "access rights" by groups admin in TellAFriend's admin
- Copy modifier.xoops_tellafriend.php into class/smarty/plugins/
 (this step can be skipped if you use it for native tellafriend modules)
- Edit the templates with links of "Tell a friend" as follows.
- Or turn "use tellafriend module" on in the preferences of the module which is made as a native with "tellafriend")

NOTE:
--------
For anti-spam, I've made a restriction to send mails per IP or uid.
If you want to change, go to preferences of TellAFriend's admin.

SAMPLES of editing the templates.
----------------------------------------
[b]news[/b]
news_article.html
[code]
[d]<a target="_top" href="<{$mail_link}>">[/d]
<a target="_top" href="<{$mail_link|xoops_tellafriend}>">
[/code]
news_archive.html
[code]
[d]<a href="<{$story.mail_link}>" target="_top" />[/d]
<a href="<{$story.mail_link|xoops_tellafriend}>" target="_top" />
[/code]

[b]mylinks[/b]
mylinks_link.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$link.mail_subject}>&amp;body=<{$link.mail_body}>">[/d]
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}>">
[/code]

[b]mydownloads[/b]
mydownloads_download.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$down.mail_subject}>&amp;body=<{$down.mail_body}>">[/d]
<a target="_top" href="<{$down.mail_body|xoops_tellafriend:$down.mail_subject}>">
[/code]

[b]Tellafriend native modules (pico, bulletin etc.)[/b]
Go to the preferences, and just turn 'Use tellafriend module' on.

Probleme avec certains hébergeurs.
----------------------------------------
Certains hébergeurs bloquent les requêtes HTTP qui contiannent une URL complete.
Dans ce cas il faut supprimer le protocole de l'URL dans le GET et le restituer dans le contenu du message.
La nouvelle fonction du plugin SMARTY s'en charge automatiquement.
Pour l'activer il faut passer en 3eme parmetre de "xoops_tellafriend" la valeur "1" dans le template appelant
le deuxième parmetre ("subject") devra aussi être renseigné (par defaut par une chaine vide))
par defaut le 3eme parametre de "xoops_tellafriend" a la valeur "0".
exemples :
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:'':1>">
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}:1>">




[/xlang:en]
[xlang:ja]

= Tell a Friend =

¤¤¤í¤¤¤íµÄÏÀ¤Ï¤¢¤ê¤Þ¤·¤¿¤¬¡¢¡ÖÍ§Ã£¤ËÃÎ¤é¤»¤ë¡×¤òmailto:¤Ç¹Ô¤¦¤Î¤Ï¡¢¤É¤¦¤ä¤Ã¤Æ¤â¡ÖÊ¸»ú²½¤±¡×¤ÏÈò¤±¤é¤ì¤Ê¤¤¤È¤¤¤¦¤Î¤¬·ëÏÀ¤Ç¤¹¡£

¤Þ¤¿¡¢¥á¡¼¥é¡¼¤¬¥»¥Ã¥È¥¢¥Ã¥×¤µ¤ì¤Æ¤¤¤ë´Ä¶­¤«¤é¤Î¥¢¥¯¥»¥¹¤Ê¤é¤È¤â¤«¤¯¡¢¥¤¥ó¥¿¡¼¥Í¥Ã¥È¥«¥Õ¥§¤Ê¤É¤«¤é¤Ç¤Ï¡¢mailto:¤Ï°ÕÌ£¤¬¤¢¤ê¤Þ¤»¤ó¡£


¤È¤¤¤¦¤ï¤±¤Ç¡¢Smarty plug-in ¤È¤ÎÁÈ¤ß¹ç¤ï¤»¤Ç¡¢¥Õ¥©¡¼¥à¥á¡¼¥ë¤òÍøÍÑ¤¹¤ë¥â¥¸¥å¡¼¥ë¤òºî¤Ã¤Æ¤ß¤Þ¤·¤¿¡£


¤³¤Î¥â¥¸¥å¡¼¥ë¤ÎÍøÍÑÊýË¡¤Ç¤¹¤¬¡¢£³¤Ä¤Î¼ê½ç¤¬É¬Í×¤Ç¤¹¡£

- ¤Þ¤º¡¢ÉáÄÌ¤Ë¥¤¥ó¥¹¥È¡¼¥ë¤·¤Æ¤¯¤À¤µ¤¤¡£

- class/smarty/plugins/ ¤Ë modifier.xoops_tellafriend.php ¤ò¥³¥Ô¡¼¤·¤Æ¤¯¤À¤µ¤¤
¡ÊºÇ½é¤«¤éÂÐ±þ¤·¤Æ¤¤¤ë¥â¥¸¥å¡¼¥ë¤ËÍøÍÑ¤¹¤ë¾ì¹ç¤ÏÉÔÍ×¤Ç¤¹¡Ë

- ¡ÖÍ§Ã£¤ËÃÎ¤é¤»¤ë¡×¥ê¥ó¥¯¤Î¤¢¤ë¥Æ¥ó¥×¥ì¡¼¥È¤òÊÔ½¸¤·¤Æ¤¯¤À¤µ¤¤¡£
¡ÊºÇ½é¤«¤éÂÐ±þ¤·¤Æ¤¤¤ë¥â¥¸¥å¡¼¥ë¤Ç¤¢¤ì¤Ð¡¢°ìÈÌÀßÄê¤ÎÊÑ¹¹¤ò¹Ô¤¤¤Þ¤¹¡Ë


¥²¥¹¥È¤Ëµö²Ä¤·¤¿¤¤¾ì¹ç¤Ï¡¢¥°¥ë¡¼¥×´ÉÍý¤«¤é¡¢¥²¥¹¥È¤ËÂÐ¤·¤Æ¥â¥¸¥å¡¼¥ë¥¢¥¯¥»¥¹¸¢¸Â¤òÍ¿¤¨¤Æ¤¯¤À¤µ¤¤¡£
¥¹¥Ñ¥àÅù¤ÎÆ§¤ßÂæ¤Ë¤µ¤ì¤Ê¤¤¤è¤¦¡¢IPËè¤â¤·¤¯¤ÏuidËè¤ËÁ÷¿®¿ôÀ©¸Â¤òÀß¤±¤Æ¤¢¤ê¤Þ¤¹¤Î¤Ç¡¢É¬Í×¤Ë±þ¤¸¤Æ¡¢¡Ö°ìÈÌÀßÄê¡×¤«¤éÊÑ¹¹¤·¤Æ¤¯¤À¤µ¤¤¡£


------------------------------------------------------------------
°Ê²¼¤Ë¥Æ¥ó¥×¥ì¡¼¥ÈÊÔ½¸¤Î¥µ¥ó¥×¥ë¤ò¼¨¤·¤Þ¤¹¡£

[b]news[/b]
news_artcle.html
[code]
[d]<a target="_top" href="<{$mail_link}>">[/d]
<a target="_top" href="<{$mail_link|xoops_tellafriend}>">
[/code]
news_archive.html
[code]
[d]<a href="<{$story.mail_link}>" target="_top" />[/d]
<a href="<{$story.mail_link|xoops_tellafriend}>" target="_top" />
[/code]

[b]mylinks[/b]
mylinks_link.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$link.mail_subject}>&amp;body=<{$link.mail_body}>">[/d]
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}>">
[/code]

[b]mydownloads[/b]
mydownloads_download.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$down.mail_subject}>&amp;body=<{$down.mail_body}>">[/d]
<a target="_top" href="<{$down.mail_body|xoops_tellafriend:$down.mail_subject}>">
[/code]

[b]TellafriendÂÐ±þ¥â¥¸¥å¡¼¥ë¤Î¾ì¹ç (pico¤äbulletinÅù)[/b]
³ºÅö¥â¥¸¥å¡¼¥ë¤Î°ìÈÌÀßÄê¤Ç¡¢¡ÖTell a Friend¥â¥¸¥å¡¼¥ë¤ò»È¤¦¡×¤ò¡Ö¤Ï¤¤¡×¤È¤·¤Þ¤¹¡£


[/xlang:ja]

