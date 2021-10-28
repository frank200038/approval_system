"use strict";

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return "";
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

const nameField = document.getElementById("name");
const contentField = document.getElementById("content");
const commentArea = document.getElementById("comment")
const removeButton = document.getElementById("remove");
const saveButton = document.getElementById("save");
const linkButton = document.getElementById("generate")
const linkPara = document.getElementById("link");
const statusArea = document.getElementById("status")
const projectID = getParameterByName("token");
const dropZone = document.getElementById("drop-zone");
const projects = loadProjectsFromLocal()
const token = document.getElementsByName("csrf-token")[0].getAttribute("content");
const project = projects.find((project) => projectID === project.link);

var imageBase64Array = []
var projectImageWithIdArray = []
var projectImageArray = []
var imageFileArray = []

const loadImages=( photoZone = undefined )=>{
    
    if (photoZone != undefined){
        console.log(photoZone)
        photoZone.innerHTML = ""
    }

    if (imageBase64Array.length != 0) {
        console.log("load image 64")
        for (let i = 0; i < imageBase64Array.length; i++) {
            addImage(imageBase64Array[i]["data"], imageBase64Array[i]["uuid"]);
      }
    }

    if(projectImageWithIdArray.length != 0){
        console.log("load image project");
        for (let i = 0; i < projectImageWithIdArray.length; i++) {
          addImage(
            projectImageWithIdArray[i]["data"],
            projectImageWithIdArray[i]["uuid"]
          );
        }
    }
    
}

const loadEditPage = (project) => {
  if (!project) {
    window.location = "/approval/admin";
  } else {
        nameField.value = project.name;
        contentField.value = project.description;
        commentArea.innerHTML = project.comment
        statusArea.innerHTML = project.status;
        if (project.password != ""){
            var link = "view?token=" +project.link +"&pass=" +project.password
            linkPara.innerHTML = `<a href="${link}">jfcgraphics.co/approval/${link}</a>`;
            console.log(link)
            console.log(linkPara.innerHTML)
        }
        
        if (project.img != undefined) {
            if (project.img.length != 0) {
                for (let i = 0; i < project.img.length; i++) {
                    var id = uuidv4();
                    console.log("To add")
                    console.log(project.img[i])
                    projectImageArray.push(project.img[i]);
                    projectImageWithIdArray.push({ data: project.img[i], uuid: id });
                }
            }
        }
    }


    loadImages();
    
}
loadEditPage(project);

function preventDefault(e) {
  e.preventDefault();
  e.stopPropagation();
}

function addImage (data,id){
    const canvas = document.createElement("canvas");
    canvas.classList.add("d-block");
    canvas.classList.add("w-100");

    const division = document.querySelector("#photo");

    const button = document.createElement("button");
    button.classList.add("rounded");
    button.classList.add("btn-primary");
    button.classList.add("remove-button");
    button.setAttribute("id", `remove-photo-${id}`);
    button.setAttribute("onclick", "removePhoto(this)");
    button.setAttribute("style", "text-align:center;padding-top:5px;padding-bottom:5px;margin-bottom:10px;");
    button.innerHTML = "Remove ⇧⇧";

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
        canvasItem.appendChild(button);
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
  
function handleFile(files) {
  const dropZoneText = document.getElementById("drop-zone-text");
  for (let file of files) {
        const typeFileCheck =
        (file.type === "image/png") |
        (file.type === "image/gif") |
        (file.type === "image/jpeg")
            ? true
            : false;

        if (typeFileCheck) {
            imageFileArray.push(file);
            console.log("image added")
            console.log(file)
            console.log(imageFileArray)
            const reader = new FileReader();
            reader.onload = () => {
                var id = uuidv4()
                addImage(reader.result,id)
                console.log("reader is: ")
                console.log(reader.result)
                imageBase64Array.push({
                  "data": reader.result,
                  "uuid": id,
                });
            };
            reader.readAsDataURL(file);

        } else {
        if (document.getElementById("drop-zone-text-error") === null) {
            dropZoneText.style.display = "none";
            const dropZoneError = document.createElement("p");
            dropZoneError.id = "drop-zone-text-error";
            dropZoneError.innerHTML = `  <img src="src/img/error.png" class="mx-auto d-block" width="50" height="65" 
            style="padding-bottom:2%;">
            "<b>`+ file.name + `</b>" is not an image <br>
            Only images are uploaded`;
            dropZone.appendChild(dropZoneError);
            setTimeout(() => {
            dropZoneText.style.display = "block";
            dropZone.removeChild(dropZoneError);
            }, 1500);
        }
    }
  }
}

function findIndex(idToFind){
    for (let i=0;i<imageBase64Array.length;i++){
        let id = imageBase64Array[i]["uuid"]
        if (id === idToFind){
            return {"from":"imageBase64","index":i}
        }
    }

    for (let i = 0; i < projectImageWithIdArray.length; i++) {
        let id = projectImageWithIdArray[i]["uuid"];
        if (id === idToFind) {
            return { "from": "projectImageWithIdArray", "index": i ,"data":projectImageWithIdArray[i]["data"]};
        }
    }
    return {"index":-1}
}

const removePhoto = (button) =>{
    var id = button.id.substring(13)
    var result = findIndex(id)

    if (result["index"] != -1){
        if (result["from"] === "imageBase64"){
            imageBase64Array.splice(result["index"],1)
            imageFileArray.splice(result["index"],1)
        }else if(result["from"] === "projectImageWithIdArray"){
            removePhotoServer(result["data"])
            projectImageWithIdArray.splice(result["index"], 1)
            projectImageArray.splice(result["index"], 1)
        }
    }

    loadImages(document.getElementById("photo"))
}

const removePhotoServer = (link)=>{
        var response = "";
        var xmlhttp = new XMLHttpRequest();
        var formData = new FormData();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                //response = JSON.parse(this.responseText);
            }
        }
        formData.append("remove", link);

        xmlhttp.open("POST", "imageOP.php", true);
        xmlhttp.send(formData);
}

const upload=()=>{

    updateProject(projectID,{
        "pictureAll":[...projectImageArray]
    })
    
    if (imageFileArray.length != 0){
        var response = "";
        var xmlhttp = new XMLHttpRequest();
        var formData = new FormData()
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
                response = JSON.parse(this.responseText);

                for (let i = 0;i<response.length;i++){
                    if (response[i]['uploaded'] === 'true'){
                        console.log(response[i]['link'])

                        updateProject(projectID, {
                          picture: response[i]["link"]
                        });

                    }else{
                        if(response[i]['error'] != undefined){
                            alert(response[i]['error'])
                        }
                    }
                }
                
                saveData()
            }
        }

        for (let i = 0;i<imageFileArray.length;i++){
            formData.append(`file-${i}`,imageFileArray[i])
        }
        formData.append("total",imageFileArray.length)
        formData.append('id',project.link)
        
        xmlhttp.open("POST", "imageOP.php", true);
        xmlhttp.send(formData);
    }else{
        saveData()
    }
}

removeButton.addEventListener("click", (e) => {
    var xmlhttp = new XMLHttpRequest();
    var formData = new FormData();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            removeProject(project.link)
            window.location = "/approval/admin";
        }
    };
    formData.append("id", project.link);
    formData.append("token", token);
    xmlhttp.open("POST", "removeProject.php", true);
    xmlhttp.send(formData);
});

const saveData=()=>{
    const name = nameField.value;
    const content = contentField.value;
    const linkTotal = JSON.stringify(project.img)
    

    var formData = new FormData();
    var response = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            console.log(response);
            response = JSON.parse(this.responseText);
            
            if (response['finished'] != undefined){
                saveButton.disabled = false
            }

            if (response['password'] != undefined){
                updateProject(projectID,{
                    password:response['password']
                })
            }

            updateProject(projectID, {
              name: name,
              content:content
            });

            location.reload()
        }
    };

    formData.append("name",name)
    formData.append("comment",content)
    formData.append('img',linkTotal)
    formData.append('link',project.link)
    formData.append('date',project.date)
    formData.append('token',token)
    xmlhttp.open("POST", "saveProjects.php", true);
    xmlhttp.send(formData);
}

saveButton.addEventListener("click",(e)=>{
    upload()
    saveButton.disabled = true
})

dropZone.addEventListener("drop", preventDefault);
dropZone.addEventListener("drag", preventDefault);
dropZone.addEventListener("dragover", preventDefault);

dropZone.addEventListener("dragover", (e) => {
  if (!dropZone.className.includes("drag-over")) {
    dropZone.classList.add("drag-over");
  }
});
dropZone.addEventListener("dragleave", (e) => {
  if (dropZone.className.includes("drag-over")) {
    dropZone.classList.remove("drag-over");
  }
});

dropZone.addEventListener("drop", (e) => {
  if (dropZone.className.includes("drag-over")) {
    dropZone.classList.remove("drag-over");
  }
 
  handleFile(e.dataTransfer.files);
});


