let keyword = document.getElementById("keyword")
let container = document.getElementById("table-container")



keyword.addEventListener("keyup", function(){
    let xhr = new XMLHttpRequest()
    
    xhr.onreadystatechange = function(){
        
        if  (xhr.readyState == 4 && xhr.status == 200 ) {
            
            container.innerHTML = xhr.responseText

        }


    }
    xhr.open("GET", "students-data.php?keyword=" + keyword.value, true)
    xhr.send()
})