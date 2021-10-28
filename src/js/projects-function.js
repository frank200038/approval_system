const sortProject = (sortBy) => {
  if (sortBy === "By Name") {
    return projects.sort((a, b) => {
      if (a.name.toLowerCase() < b.name.toLowerCase()) {
        return -1;
      } else if (a.name.toLowerCase() > b.name.toLowerCase()) {
        return 1;
      } else {
        return 0;
      }
    });
  } else if (sortBy === "By Creation Date") {
    return projects.sort((a, b) => {
      if (a.created > b.created) {
        return -1;
      } else if (a.created < b.created) {
        return 1;
      } else {
        return 0;
      }
    });
  } else {
    return projects;
  }
};

const saveProjects = () => {
  localStorage.setItem("projects", JSON.stringify(projects));
};


const loadProjectsFromLocal = () => {
    const recipesJSON = localStorage.getItem("projects");
    try {
        return recipesJSON ? JSON.parse(recipesJSON) : [];
    } catch (e) {
        return [];
    }
};

const updateProject = (projectID, update) => {
    const project = projects.find((projectToFind) => projectToFind.link === projectID);
    console.log(project);

    if (!project) {
        return;
    }

    if (typeof update.name === "string") {
        project.name = update.name;
    }

    if (typeof update.content === "string") {
        console.log("description update: " + update.content);
        project.description = update.content;
    }

    if (typeof update.password === "string"){
        console.log("password update: "+update.password)
        project.password = update.password
    }

    if (typeof update.picture === "string") {
        console.log("update one: ");
        console.log(update.picture);
        project.img.push(update.picture);
    }

    if (Array.isArray(update.pictureAll)){
        console.log("update all: ")
        console.log(update.pictureAll)
        project.img = update.pictureAll
    } 
    
    saveProjects();
};

const removeProject = (projectID) => {
    const projectIndex = projects.findIndex((project) => project.link === projectID);
    if (projectIndex > -1) {
      projects.splice(projectIndex, 1);
      saveProjects();
    }
};

const createProject = () => {
  
    const newProject = {
      name: "No Name",
      status: "NOT APPROVED",
      date: moment().format("llll"),
      comment: "",
      img: [],
      link: uuidv4(),
      description:"",
      password:""
    };
    projects.push(newProject);
    return newProject.link;
};
