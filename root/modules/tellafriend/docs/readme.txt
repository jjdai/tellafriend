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

Probleme avec certains h�bergeurs.
----------------------------------------
Certains h�bergeurs bloquent les requ�tes HTTP qui contiannent une URL complete.
Dans ce cas il faut supprimer le protocole de l'URL dans le GET et le restituer dans le contenu du message.
La nouvelle fonction du plugin SMARTY s'en charge automatiquement.
Pour l'activer il faut passer en 3eme parmetre de "xoops_tellafriend" la valeur "1" dans le template appelant
le deuxi�me parmetre ("subject") devra aussi �tre renseign� (par defaut par une chaine vide))
par defaut le 3eme parametre de "xoops_tellafriend" a la valeur "0".
exemples :
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:'':1>">
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}:1>">




[/xlang:en]
[xlang:ja]

= Tell a Friend =

����������Ϥ���ޤ���������ͧã���Τ餻��פ�mailto:�ǹԤ��Τϡ��ɤ���äƤ��ʸ�������פ��򤱤��ʤ��Ȥ����Τ������Ǥ���

�ޤ����᡼�顼�����åȥ��åפ���Ƥ���Ķ�����Υ��������ʤ�Ȥ⤫�������󥿡��ͥåȥ��ե��ʤɤ���Ǥϡ�mailto:�ϰ�̣������ޤ���


�Ȥ����櫓�ǡ�Smarty plug-in �Ȥ��Ȥ߹�碌�ǡ��ե�����᡼������Ѥ���⥸�塼����äƤߤޤ�����


���Υ⥸�塼���������ˡ�Ǥ��������Ĥμ�礬ɬ�פǤ���

- �ޤ������̤˥��󥹥ȡ��뤷�Ƥ���������

- class/smarty/plugins/ �� modifier.xoops_tellafriend.php �򥳥ԡ����Ƥ�������
�ʺǽ餫���б����Ƥ���⥸�塼������Ѥ���������פǤ���

- ��ͧã���Τ餻��ץ�󥯤Τ���ƥ�ץ졼�Ȥ��Խ����Ƥ���������
�ʺǽ餫���б����Ƥ���⥸�塼��Ǥ���С�����������ѹ���Ԥ��ޤ���


�����Ȥ˵��Ĥ��������ϡ����롼�״������顢�����Ȥ��Ф��ƥ⥸�塼�륢���������¤�Ϳ���Ƥ���������
���ѥ�����Ƨ����ˤ���ʤ��褦��IP��⤷����uid������������¤��ߤ��Ƥ���ޤ��Τǡ�ɬ�פ˱����ơ��ְ�������פ����ѹ����Ƥ���������


------------------------------------------------------------------
�ʲ��˥ƥ�ץ졼���Խ��Υ���ץ�򼨤��ޤ���

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

[b]Tellafriend�б��⥸�塼��ξ�� (pico��bulletin��)[/b]
�����⥸�塼��ΰ�������ǡ���Tell a Friend�⥸�塼���Ȥ��פ�֤Ϥ��פȤ��ޤ���


[/xlang:ja]

