'use strict'


const approveButton = document.getElementById("approve")
const commentButton = document.getElementById("change")
const commentArea = document.getElementById("comment")
const urlParam = new URLSearchParams(location.search);
const tokenSession = document.getElementsByName("csrf-token")[0].getAttribute("content");
const pass = urlParam.get("pass");
const token = urlParam.get("token");
const loadViewPage=()=>{

    var response = "";
    var xmlhttp = new XMLHttpRequest();
    var formData = new FormData();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            response = JSON.parse(this.responseText);
            
            if (response["error"] != undefined){
                alert(response["error"])
            }else{
                var name = response["name"];
                var imagePathJson = JSON.parse(response["img"]);
                for (let i = 0; i < imagePathJson.length; i++) {
                  addImage(imagePathJson[i])
                }
                var status = response["status"]
                var date = response["date"];
                var comment = response["comment"]
                var description = response['description']

                loadInfo(name,status,description,comment,date)
                changeDOMStatus(status)
            }
        }
    };

    formData.append("password", pass);
    formData.append("token", token);

    xmlhttp.open("POST", "approveProjects.php", true);
    xmlhttp.send(formData);
}

loadViewPage()
function addImage(data){
    const canvas = document.createElement("canvas");
    canvas.classList.add("d-block");
    canvas.classList.add("w-100");

    const division = document.querySelector("#photo");

    const image = new Image();
    const canvasItem = document.createElement("div")

    const context = canvas.getContext('2d')
    
    context.webkitImageSmoothingEnabled = false;
    context.imageSmoothingEnabled = false;
    image.src = data
    image.onload = () => {
        const newDimension = resizeImage(image, 700,850);
        canvas.width = newDimension.width;
        canvas.height = newDimension.height;
        context.drawImage(image, 0, 0, newDimension.width, newDimension.height);

        canvasItem.appendChild(canvas)
        division.appendChild(canvasItem);
    }
}

function resizeImage(img, maxHeight, maxWidth) {
  let ratio = 0;
  let width = img.width;
  let height = img.height;

  if (img.height > maxHeight) {
    ratio = maxHeight / img.height;
    width = img.width * ratio;
    height = img.height * ratio;
  }

  if (img.width > maxWidth) {
    ratio = maxWidth / img.width;
    width = img.width * ratio;
    height = img.height * ratio;
  }

  console.log(width);
  console.log(height);

  return { width: width, height: height };
}

const loadInfo=(projectName,projectStatus,projectDescription,projectComment,projectDate)=>{
    const name = document.getElementById("name")
    const status = document.getElementById("status")
    const date = document.getElementById("date")
    const comment = document.getElementById("comment")
    const description = document.getElementById('description')

    name.innerHTML = projectName || ""
    status.innerHTML = projectStatus || ""
    date.innerHTML = projectDate || ""
    description.innerHTML = projectDescription || ""
    comment.innerHTML = projectComment || ""

}

approveButton.addEventListener("click", (e) => {
    approve()
});

commentButton.addEventListener("click", (e) => {
  comment();
});

const approve=()=>{
    var response = "";
    var xmlhttp = new XMLHttpRequest();
    var formData = new FormData();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            response = JSON.parse(this.responseText);

            if (response["error"] != undefined) {
                alert(response["error"]);
            }else{
                sendEmail("approval")
               // location.reload()
            }
        }
    };

    formData.append("password", pass);
    formData.append("token", token);
    formData.append("approve","true")
    xmlhttp.open("POST", "approveProjects.php", true);
    xmlhttp.send(formData);
}

const comment = () => {
    var response = "";
    var xmlhttp = new XMLHttpRequest();
    var formData = new FormData();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            response = JSON.parse(this.responseText);

            if (response["error"] != undefined) {
                alert(response["error"]);
                location.reload()
            }else{
                sendEmail("comment",document.getElementById("comment").innerHTML)
                
            }
        }
    };

    formData.append("password", pass);
    formData.append("token", token);
    formData.append("comment", commentArea.value);
    xmlhttp.open("POST", "approveProjects.php", true);
    xmlhttp.send(formData);

    
};

const sendEmail = (purpose,comment="") =>{
    var responseEmail = "";
    var xmlhttpEmail = new XMLHttpRequest();
    var formDataEmail = new FormData();
    xmlhttpEmail.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            responseEmail = JSON.parse(this.responseText);

            if (responseEmail["result"] != undefined) {
                
                alert(responseEmail["result"]);
                location.reload()
            }
        }
    };

    formDataEmail.append("token", tokenSession);
    formDataEmail.append("purpose", purpose);
    formDataEmail.append("comment",comment);
    formDataEmail.append("link", "jfcgraphics.co/approval/edit?token=" + token);
    formDataEmail.append("name", document.getElementById("name").innerHTML);
    xmlhttpEmail.open("POST", "sendEmail.php", true);
    xmlhttpEmail.send(formDataEmail);

}


const changeDOMStatus=(status)=>{
    if (status === "APPROVED"){
        const statusArea = document.getElementById("status")
        statusArea.style.color = "green"
        approveButton.disabled = true
        commentButton.disabled = true
        commentArea.disabled = true
    }
}