function setPage(container, count, pageindex) {
var container = container;
var count = count;
var pageindex = pageindex;
var a = [];
  if (pageindex == 1) {
    a[a.length] = "<a href=\"#\" class=\"prev unclick\">prev</a>";
  } else {
    a[a.length] = "<a href=\"#\" class=\"prev\">prev</a>";
  }
  function setPageList() {
    if (pageindex == i) {
      a[a.length] = "<a href=\"#\" class=\"on\">" + i + "</a>";
    } else {
      a[a.length] = "<a href=\"#\">" + i + "</a>";
    }
  }
  if (count <= 10) {
    for (var i = 1; i <= count; i++) {
      setPageList();
    }
  }
  else {
    if (pageindex <= 4) {
      for (var i = 1; i <= 5; i++) {
        setPageList();
      }
      a[a.length] = "...<a href=\"#\">" + count + "</a>";
    } else if (pageindex >= count - 3) {
      a[a.length] = "<a href=\"#\">1</a>...";
      for (var i = count - 4; i <= count; i++) {
        setPageList();
      }
    }
    else {
      a[a.length] = "<a href=\"#\">1</a>...";
      for (var i = pageindex - 2; i <= pageindex + 2; i++) {
        setPageList();
      }
      a[a.length] = "...<a href=\"#\">" + count + "</a>";
    }
  }
  if (pageindex == count) {
    a[a.length] = "<a href=\"#\" class=\"next unclick\">next</a>";
  } else {
    a[a.length] = "<a href=\"#\" class=\"next\">next</a>";
  }
  container.innerHTML = a.join("");
    
  var pageClick = function() {
    var oAlink = container.getElementsByTagName("a");
    var inx = pageindex; 
    oAlink[0].onclick = function() { //pre page
      if (inx == 1) {
        return false;
      }
      inx--;
      //setPage(container, count, inx);
      var url=(window.location+"").substring(0, (window.location+"").indexOf("?"))+"?page=wp-spatialtree-settings&pageNum="+inx;
				window.open(url, "_self");
      return false;
    }
    for (var i = 1; i < oAlink.length - 1; i++) { //click the page NO.
      oAlink[i].onclick = function() {
        inx = parseInt(this.innerHTML);
        //setPage(container, count, inx);
        
      var url=(window.location+"").substring(0, (window.location+"").indexOf("?"))+"?page=wp-spatialtree-settings&pageNum="+inx;
				window.open(url, "_self");
        return false;
      }
    }
    oAlink[oAlink.length - 1].onclick = function() { //next page
      if (inx == count) {
        return false;
      }
      inx++;
      //setPage(container, count, inx);
      var url=(window.location+"").substring(0, (window.location+"").indexOf("?"))+"?page=wp-spatialtree-settings&pageNum="+inx;
				window.open(url, "_self");
      return false;
    }
  } ()
}

function pageClick(inx)
			{
				var url=window.location+"&pageNum="+inx;
				window.open(url, "_self");
			}