"use strict";

let filter = {
  search: "",
  sortBy: "By Creation Date",
};

const setFilter = (update) => {
  if (typeof update.search === "string") {
    filter.search = update.search;
  }

  if (typeof update.sortBy === "string") {
    filter.sortBy = update.sortBy;
  }
  console.log(filter);
};

const generateDOM = (project) => {
  const div = document.createElement("div");
  div.classList.add("card");
  var color = ""
  if (project.status == "NOT APPROVED"){
        color = 'style="color:red;"'
  }else{
      color = 'style="color:green";"';
  }
  
  var comment = project.comment != undefined ? project.comment : ""

  div.innerHTML = `
      <div class="card-body">
          <h3 class="card-title">${project.name}</h3>
          <p class="card-text"`+color+`>${project.status} </p>
          <p style="font-size: 1.5rem;color:grey">${comment}</p>
          <p style="font-size: 0.8rem;color:grey">Last Update Time: ${project.date}</p>
          <a href='/approval/edit?token=${project.link}' class='btn btn-primary stretched-link'>View Project</a> 
          </div>
      `
  return div;
};

const renderProject = () => {
  console.log("rendering")
  let projectRenderArray = [];
  const sortedProject = sortProject(filter.sortBy);
  const filteredProjects = sortedProject.filter((project) =>
    project.name.toLowerCase().includes(filter.search.toLowerCase())
  );
  console.log(filteredProjects);
  const div = document.querySelector(".recipe-container");
  div.innerHTML = "";
  filteredProjects.forEach((project)=>{
      const oneProject = generateDOM(project)
      projectRenderArray.push(oneProject)
      console.log(oneProject)
      div.appendChild(oneProject)
  })
};
