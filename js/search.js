function searchPost(curPage, countResource){
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
        var block = document.getElementsByClassName("items-block")[0];
        block.innerHTML = request.responseText;
        repaintPaginationBar(curPage, countResource);
    };
    var postData = "searchRequest=" + input;
    request.open("POST", "/index/search", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(postData);
}
