s/{{{DB_HOST}}}/localhost/;
s/{{{DB_NAME}}}/student_administration_framework/;
s/{{{DB_USER}}}/studadmin_user/;
s/{{{DB_PWD}}}/studadmin_user_01234/;

s!{{{BACKENDAPP_URL}}}!http://example.com?property_id={property_id}&pic_id={pic_id}!;
s!{{{BACKENDAPP_PARAMNAME_PROP}}}!property_id!;
s!{{{BACKENDAPP_PARAMNAME_PIC}}}!pic_id!;
s!{{{BACKENDAPP_PLACEHOLDER_PROP}}}!{property_id}!;
s!{{{BACKENDAPP_PLACEHOLDER_PIC}}}!{pic_id}!;
