


$(document).ready(function () {

});


function visibilityChange(modal, value) {
    let cus = document.querySelector(`#${modal} .custom-users-selector`);
    if (value == 3) {
        cus.classList.remove("hide");
    } else {
        cus.classList.add("hide");
    }
}


function createTask() {
    let overlay = document.querySelector("#addTaskModal .modal-dialog .overlay");
    let name = document.querySelector("#addTaskModal #task-name").value;
    let visibility = document.querySelector("#addTaskModal #visibility").value;
    let customUsers = document.querySelector("#addTaskModal #custom-users");
    let _token = document.querySelector("input[name='_token']").value;
    customUsers = getSelectValues(customUsers);
    console.log(name, visibility, customUsers);

    let payload = new FormData();
    payload.append("name", name);
    payload.append("visibility", visibility);
    payload.append("customUsers", customUsers);
    payload.append("_token", _token);

    overlay.classList.toggle("hide");
    fetch("todo/task/create",{
        method : "POST",
        body : payload
    })
    .then(r => r.json())
    .then(r => {
        if ( r.msg == "success" ) {
            let tr = `<table>
                        <tr class="text-center" id="task-${r.task.id}" data-status="1"  data-visibility="${visibility}">
                            <td class="px-1">
                                <span class="task-number">1</span>
                            </td>
                            <td class="text-center px-1">
                                <div class="form-check text-center">
                                    <input onchange="taskChange(${r.task.id})" class="form-check-input status-checkbox mt-2" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </td>
                            <td class="task-name">${name}</td>
                            <td class="">
                                <i class="fas fa-pen mr-2 cursor-pointer"  onclick="editTask(${r.task.id})"></i>
                                <i class="fas fa-trash-alt text-danger cursor-pointer" onclick="deleteTask(${r.task.id})"></i>
                            </td>
                            <td  class="visibility-tag">
                                <span
                                class="badge border border-${visibility == 1 ? "success" : ""}  border-${visibility == 2 ? "danger" : ""}  border-${visibility == 3 ? "dark" : ""} p-1">
                                    ${visibility == 1 ? "public <i class='fas fa-users'></i>" : ""}
                                    ${visibility == 2 ? "only me <i class='fas fa-lock'></i>" : ""}
                                    ${visibility == 3 ? `custom <i class='fas fa-cog' data-permitted-user='[${customUsers}]'></i>` : ""}
                                </span>
                            </td>
                        </tr></table>`;
            tr = (new DOMParser().parseFromString(tr, "text/html")).querySelector("tr");

            [...document.querySelectorAll(".task-container tr")]
            .forEach((tr, i) => {
                tr.querySelector("td").innerText = i + 2;
            });
            document.querySelector(".task-container").prepend(tr);

            $('#addTaskModal').modal('hide');
            document.querySelector("#addTaskModal #task-name").value = "";
            document.querySelector("#addTaskModal #visibility").item(0).checked = true;
            document.querySelector("#addTaskModal #visibility").value = "Public";
            document.querySelector("#addTaskModal #custom-users").value = "";
        } else {
            $('#addTaskModal').modal('hide');
            document.querySelector("#addTaskModal #task-name").value = "";
            document.querySelector("#addTaskModal #visibility").value = "";
            document.querySelector("#addTaskModal #custom-users").value = "";
            alert("Something Worng Try again!!!");
        }
        overlay.classList.toggle("hide");
    });
}

function deleteTask( taskID ) {
    let overlay = document.querySelector(".todo-container .overlay");
    overlay.classList.toggle("hide");
    let task = document.querySelector(`#task-${taskID}`);

    let _token = document.querySelector("input[name='_token']").value;
    let taskid = taskID;
    let status = !parseInt(task.dataset.status) + 0;

    let payload = new FormData();
    payload.append("_token", _token);
    payload.append("taskid", taskid);
    payload.append("status", status);

    fetch("todo/task/destroy", {
        method: "POST",
        body: payload
    })
    .then(r => r.json())
    .then(r => {
        if (r.msg == "success") {
            overlay.classList.toggle("hide");
            task.remove();
        } else {

        }
    });
}


function editTask( taskID ) {
    let editTaskModal = document.querySelector("#editTaskModal");
    let task = document.querySelector("#task-" + taskID);
    editTaskModal.querySelector("#task-name").value = task.querySelector(".task-name").innerText;
    editTaskModal.querySelector("input[name='taskid']").value = taskID;

    console.log(editTaskModal.querySelector("#visibility"), task.dataset.visibility);
    editTaskModal.querySelector("#visibility").item( parseInt(task.dataset.visibility)-1 ).selected = true;

    console.log(task.dataset.visibility);
    if ( task.dataset.visibility == 3 ) {
        editTaskModal.querySelector(".custom-users-selector").classList.remove("hide");

        let options = [...editTaskModal.querySelector("#custom-users").options];
        // console.log(options, JSON.parse(task.querySelector("i.fa-cog").dataset.permittedUser));
        options.forEach( o => {
            console.log(o, o.value, );
            if ( JSON.parse(task.querySelector("i.fa-cog").dataset.permittedUser).includes( parseInt(o.value) ) ) {
                o.selected = true;
            }
        });
    } else {
        editTaskModal.querySelector(".custom-users-selector").classList.add("hide");
    }

    $("#editTaskModal").modal("toggle");
}


function updateTask() {

    let taskid = editTaskModal.querySelector("input[name='taskid']").value;
    let task = document.querySelector("#task-" + taskid);

    let name = document.querySelector("#editTaskModal #task-name").value;
    let customUsers = document.querySelector("#editTaskModal #custom-users");
    let visibility = document.querySelector("#editTaskModal #visibility").value;
    let _token = document.querySelector("input[name='_token']").value;
    customUsers = getSelectValues(customUsers);

    let payload = new FormData();
    payload.append("name", name);
    payload.append("taskid", taskid);
    payload.append("customUsers", customUsers);
    payload.append("visibility", visibility);
    payload.append("_token", _token);

    // make update request
    fetch("todo/task/update", {
        method: "POST",
        body: payload
    })
    .then( r => r.json() )
    .then( r => {
        if ( r.msg == "success" ) {
            console.log(task);
            task.querySelector(".task-name").innerText = name;
            task.dataset.visibility = visibility;
            if ( visibility == 1 ) {
                task.querySelector(".visibility-tag").innerHTML =
                `<span class=" badge border border-success"> public <i class="fas fa-users ml-1"></i></span>`;
            }
            if ( visibility == 2 ) {
                task.querySelector(".visibility-tag").innerHTML =
                `<span class=" badge border border-danger"> only me <i class="fas fa-lock"></i></span>`;
            }
            if ( visibility == 3 ) {
                task.querySelector(".visibility-tag").innerHTML =
                `<span class=" badge border border-warning"> custom <i class="fas fa-cog" data-permitted-user="[${customUsers}]"></i></span>`;
            }
            $("#editTaskModal").modal("toggle");
        } else {

        }
    });




}

// helper function
function getSelectValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;

    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];

        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }
    return result;
}

function taskChange( taskID ) {
    let overlay = document.querySelector(".todo-container .overlay");
    overlay.classList.toggle("hide");
    let task = document.querySelector(`#task-${taskID}`);

    let _token = document.querySelector("input[name='_token']").value;
    let taskid = taskID;
    console.log(parseInt(task.dataset.status));
    let status = parseInt(task.dataset.status) ? 0 : 1;

    let payload = new FormData();
    payload.append("_token", _token);
    payload.append("taskid", taskid);
    payload.append("status", status);

    fetch("todo/task/update/status",{
        method : "POST",
        body : payload
    })
    .then(r=>r.json())
    .then(r => {
        if ( r.msg == "success" ) {
            overlay.classList.toggle("hide");
            task.querySelector(".task-name").classList.toggle("done");
            task.dataset.status = status;
            // console.log(task, `${status ? 0 : 1}`,  );
        } else {
            task.querySelector("input[type='checkbox']").checked = !status;
        }
    });
}


function search( inputField ) {
    let trs = [...document.querySelectorAll("tbody tr")];

    trs.forEach(tr => {
        let taskname = tr.querySelector(".task-name").innerText;
        if ( taskname.toLocaleLowerCase().includes(inputField.value.toLocaleLowerCase() ) ) {
            tr.classList.remove("hide");
        } else {
            tr.classList.add("hide");
        }
    });

    trs.forEach(tr => {
        let taskname = tr.querySelector(".task-name").innerText;
        if ( !inputField.value.length ) {
            tr.classList.remove("hide");
        }
    });
}




//
