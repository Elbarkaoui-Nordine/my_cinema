class List {
  constructor(selector, sendlist) {
    this.selector = selector;
    this.sendlist = sendlist;
  }

  add(task) {
    this.selector.append(task.html());
  }

  getValues() {
    let s = $(this.selector).find("h2");
    let ret = [];
    for (let i = 0; i < s.length; i++) {
      ret.push(s[i].innerText);
    }
    return ret;
  }

  save() {
    let data = {};
    data[this.sendlist] = this.getValues();
    $.ajax({
      type: "POST",
      url: "./save.php",
      data: data,
      success: val => {
        $("#result").append(val);
      }
    });
  }

  load() {
    $.ajax({
      type: "GET",
      url: "./load.php",
      success: val => {
        val = JSON.parse(val);
        console.log(val);
        for (let i in val) {
          if (val[i]["list"] == this.sendlist) {
            let newTask = new Task(val[i].value);
            this.add(newTask);
          }
        }
      }
    })
  }
}

class Task {
  constructor(val, list) {
    this.val = val;
    this.currentList = list
  }

  done() {
    this.li = list_todo.selector.removeChild(this.li);
    list_done.selector.append(this.li);
    this.li.removeChild(this.b1);
    this.currentList = "done";
  }

  suppr() {
    if (this.currentList == "todo")
      list_todo.selector.removeChild(this.li);
    else
      list_done.selector.removeChild(this.li)
  }

  html() {
    this.li = document.createElement("li");
    this.li.classList.add("item");

    let h2 = document.createElement("h2");
    h2.classList.add("subitem");
    h2.innerHTML = this.val;

    this.b1 = document.createElement("button");
    this.b1.classList.add("subitem");
    this.b1.innerHTML = "Fini";

    let b2 = document.createElement("button");
    b2.classList.add("subitem");
    b2.innerHTML = "Suppr";

    this.b1.addEventListener("click", this.done.bind(this));

    b2.addEventListener("click", this.suppr.bind(this));

    this.li.appendChild(h2);
    this.li.appendChild(this.b1);
    this.li.appendChild(b2);
    return this.li;
  }
}

let list_todo = new List($("#list_todo")[0], "todo");
let list_done = new List($("#list_done")[0], "done");

$("#newtask").click(() => {
  let newTask = new Task($("#task").val(), "todo");
  list_todo.add(newTask);
});

$("#save").click(() => {
  list_todo.save();
  list_done.save();
});

$("#load").click(() => {
  list_todo.load();
  list_done.load();
});