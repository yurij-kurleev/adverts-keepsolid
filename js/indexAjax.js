function ajaxPagination(element, resource, countResource){
    var request = getXmlHttpRequest();
    var curPage = document.getElementById("cur").firstChild.nodeValue * 1;
    request.onreadystatechange = function () {
        if(request.readyState != 4){
            return;
        }
        if(request.status != 200){
            alert("Что-то случилось: " + request.statusText);
            return;
        }
        var block = document.getElementsByClassName("items-block")[0];
        block.innerHTML = request.responseText;
        document.getElementById("cur").innerHTML = curPage;
        repaintPaginationBar(curPage, countResource);
    };
    if(element.id == "next"){
        curPage += 1;
    } else {
        curPage -= 1;
    }
    var url = resource + curPage;
    request.open("GET", url, true);
    request.send(null);
}

function repaintPaginationBar(curPage, countResource){
    var request = getXmlHttpRequest();
    var input = document.getElementById("searchRequest").value;
    request.onreadystatechange = function () {
        if(request.readyState != 4){
            return;
        }
        if(request.status != 200){
            alert("Что-то случилось: " + request.statusText);
            return;
        }
        var allPages = request.responseText;
        if(allPages == curPage && allPages != 1){
            document.getElementById("prev").style.display = "block";
            document.getElementById("cur").firstChild.nodeValue = curPage;
        } else if(allPages == 1 || allPages == 0) {
            document.getElementById("cur").firstChild.nodeValue = curPage;
        } else if(curPage == 1 && allPages != 1) {
            document.getElementById("next").style.display = "block";
            document.getElementById("cur").firstChild.nodeValue = curPage;
        } else {
            document.getElementById("next").style.display = "block";
            document.getElementById("prev").style.display = "block";
            document.getElementById("cur").firstChild.nodeValue = curPage;
        }
    };
    var postData = "searchRequest=" + input;
    console.log(postData);
    request.open("POST", countResource, true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(postData);
}

function showAuthMenu() {
    document.getElementsByClassName("dark-layout")[0].style.display = "block";
    var form = document.getElementsByClassName("popup-form")[0];
    form.style.display = "block";
    /*form.style.top = "100px";
    form.style.left = "35%";*/
}

function closeAuthForm() {
    document.getElementsByClassName("dark-layout")[0].style.display = "none";
    var form = document.getElementsByClassName("popup-form")[0];
    form.style.display = "none";
}

function hideError() {
    document.getElementsByClassName("error-msg")[0].style.display = "none";
}

function deletePost(post_id) {
    var request = getXmlHttpRequest();
    var curPage = document.getElementById("cur").firstChild.nodeValue * 1;
    console.log("deletePost: " + curPage);
    request.onreadystatechange = function () {
        if (request.readyState != 4) {
            return;
        }
        if (request.status != 200) {
            alert("Что-то случилось: " + request.statusText);
            return;
        }
        var block = document.getElementsByClassName("items-block")[0];
        block.innerHTML = request.responseText;
        repaintPaginationBar(curPage);
    };
    if(document.getElementsByClassName("post").length == 1){
        curPage--;
    }
    var postData = "id_ad=" + post_id + "&id_page=" + curPage;
    request.open("POST", "/index/delete", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(postData);
}