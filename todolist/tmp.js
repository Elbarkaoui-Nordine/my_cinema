class List {
    constructor(selector, send_list) {
      this.selector = selector;
      this.send_list = send_list;
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
      data[this.send_list] = this.getValues();
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
        data: {},
        success: val => {
          val = JSON.parse(val);
          for (let i = 0; i < val.length; i++) {
            let task = new Task(val[i].value);
            if (val[i].list == this.send_list) {
              this.add(task);
            }
          }
        }
      });
    }
  }
  
  class Task {
    constructor(val) {
      this.val = val;
      this.li = document.createElement("li");
      this.currentList = list_todo;
    }
  
    done() {
      this.li = list_todo.selector.removeChild(this.li);
      list_done.selector.append(this.li);
      this.li.removeChild(this.b1);
      this.currentList = list_done;
    }
  
    suppr() {
      this.currentList.selector.removeChild(this.li);
    }
  
    html() {
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
  
  var list_todo = new List($("#list_todo")[0], "todo");
  let list_done = new List($("#list_done")[0], "done");
  
  $("#newtask").click(() => {
    let task = new Task($("#task").val());
    list_todo.add(task);
  });
  
  $("#save").click(() => {
    list_todo.save();
    list_done.save();
  });
  
  $("#load").click(() => {
    list_todo.load();
    list_done.load();
  });
  