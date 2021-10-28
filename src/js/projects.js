'use strict'

let projects = []

const loadProjects = () => {
    var token = document.getElementsByName("csrf-token")[0].getAttribute("content")
    var response = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            console.log(this.responseText)
            response = JSON.parse(this.responseText)
            console.log(response)
            for (let i=0;i<response.length;i++){
                addProjects(response[i])
            }
            console.log(projects)
            saveProjects()
            loadStatistics()
            renderProject()
        }
    }
    xmlhttp.open("GET","getProjects.php?token="+token,true)
    xmlhttp.send();
    
}

const addProjects = (project) => {
    var projectToAdd = {}
    projectToAdd.name = project["NAME"]
    projectToAdd.status = project["STATUS"]
    projectToAdd.comment = project["COMMENT"]
    projectToAdd.description = project["DESCRIPTION"]
    var imagePathJson = JSON.parse(project["IMG_PATH"])
    var image = []
    for (let i=0;i<imagePathJson.length;i++){
        image.push(imagePathJson[i])
    }
    projectToAdd.img = image
    
    projectToAdd.link = project["TOKEN"]
    projectToAdd.date = project["DATE"]
    projectToAdd.password = project["PASSWORD"]
    projects.push(projectToAdd)
}

const loadStatistics = () => {
  var approved = document.querySelector(".approved");
  var notApproved = document.querySelector(".not-approved");
  var numberApproved = 0;
  for (let i = 0; i < projects.length; i++) {
    if (projects[i].status == "APPROVED") {
      numberApproved++;
    }
  }
  var numberNotApproved = projects.length - numberApproved;
  var approveText = document.createElement("p");
  approveText.innerHTML = "# of Approved: " + numberApproved;
  approveText.style.setProperty("color", "green");
  approved.appendChild(approveText);

  var notApproveText = document.createElement("p");
  notApproveText.innerHTML = "# of Not Approved: " + numberNotApproved;
  notApproveText.style.setProperty("color", "red");
  notApproved.appendChild(notApproveText);
};

loadProjects()

document.querySelector("#New").addEventListener("click", (e) => {
  const id = createProject();
  saveProjects();
  console.log("id is "+id)
  window.location = `/approval/edit?token=${id}`;
});

let dropdown = document.getElementsByClassName("dropdown-item");
for (let item of dropdown) {
  item.addEventListener("click", (e) => {
    const menuTitle = document.querySelector("#dropdown");
    menuTitle.textContent = e.target.innerHTML;
    setFilter({
      sortBy: e.target.innerHTML,
    });
    renderProject();
  });
}

document.querySelector("#search").addEventListener("input", (e) => {
  setFilter({
    search: e.target.value,
  });
  renderProject();
});

