jQuery.fn.print=function(){if(this.size()>1){this.eq(0).print();return}else if(!this.size()){return}var e="printer-"+(new Date).getTime();var t=$("<iframe name='"+e+"'>");t.css("width","1px").css("height","1px").css("position","absolute").css("left","-9999px").appendTo($("body:first"));var n=window.frames[e];var r=n.document;var i=$("<div>").append($("style").clone());r.open();r.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');r.write("<html>");r.write("<body>");r.write("<head>");r.write("<title>");r.write(document.title);r.write("</title>");r.write(i.html());r.write("</head>");r.write(this.html());r.write("</body>");r.write("</html>");r.close();n.focus();n.print();setTimeout(function(){t.remove()},60*1e3)}