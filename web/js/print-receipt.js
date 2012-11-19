function openContent(id){ // dynamically create page, print, and auto close
str=document.getElementById(id).innerHTML
newwin=window.open(location.href,'newwin','left=100,top=100,width=600,height=600,scrollbars=1,resizable=1');
newwin.document.write('<HTML>\n<HEAD>\n');
newwin.document.write('<TITLE>Print Page</TITLE>\n');
newwin.document.write('<script>\n');
newwin.document.write('function chkstate(){\n');
newwin.document.write('if(document.readyState=="complete"){\n');
newwin.document.write('window.close()\n');
newwin.document.write('}\n');
newwin.document.write('else{\n');
newwin.document.write('setTimeout("chkstate()",2000)\n');
newwin.document.write('}\n');
newwin.document.write('}\n');
newwin.document.write('function print_win(){\n');
newwin.document.write('window.print();\n');
newwin.document.write('chkstate();\n');
newwin.document.write('}\n');
newwin.document.write('<\/script>\n');
newwin.document.write('</HEAD>\n');
newwin.document.write('<BODY>\n');
newwin.document.write(str);
newwin.document.write('</BODY>\n');
newwin.document.write('</HTML>\n');
newwin.document.close();

//if(window.opener != top){window.opener = top}
}