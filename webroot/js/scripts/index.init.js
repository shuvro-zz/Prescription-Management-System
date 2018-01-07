jQuery(function() {
	"use strict";
	var $dash = $(".page-dashboard");

	// Initialize sparklines
	function initSparklines() {
		// dash-head 
		// all the sparkline values and options are supplied from html.
		$dash.find(".sparkline").sparkline('html', {
			enableTagOptions: true,
			tagOptionsPrefix: "data-"
		});
	}

	// pie chart
	function initEasyPieChart() {
		var charts = [
			{
				selector: ".easypiechart.storageOpts",
				options: {
					size: 100,
					lineWidth: 2,
					lineCap: "square",
					barColor: "#E91E63"
				}
			},
			{
				selector: ".easypiechart.serverOpts",
				options: {
					size: 100,
					lineWidth: 2,
					lineCap: "square",
					barColor: "#4CAF50"
				}
			},
			{
				selector: ".easypiechart.clientOpts",
				options: {
					size: 100,
					lineWidth: 2,
					lineCap: "square",
					barColor: "#FDD835"
				}
			}
		];

		charts.forEach(function(chart) {
			$(chart.selector).easyPieChart(chart.options);
		});
	}

	// rating symbol via external plugin (in angularjs version, it is included in angular-bootstrap)
	function initRating() {
		$("input.rating-control").rating();
	}


	// Todo App with localstorage
	function TodoApp() {
		var $todoApp = $("#todoApp");
		var STORAGE_ID = "_todo-task";

		var todoStore = {
			todos : [],

			get : function() {
				return JSON.parse(localStorage.getItem(STORAGE_ID));
			},

			put : function(todos) {
				localStorage.setItem(STORAGE_ID, JSON.stringify(todos));
			}
		};

		var demoTodos = [ 
			{ title: "Eat healthy, Eat fresh", completed: false },
			{ title: "Donate some money", completed: true },
			{ title: "Wake up at 5:00 A.M", completed: false },
			{ title: "Hangout with friends at 12:00", completed: false},
			{ title: "Another todo on the list. Add as many you want.", completed: false },
			{ title: "The last but not the least.", completed: true
			}
		];

		var todos = todoStore.get() || demoTodos;
		var scope = {
			newTodo : "",
			remainingCount: todos.filter(function(val, i, arr) { return (val.completed == false) }).length,
			editedTodo : null,
			originalTodo: "",
			statusFilter: null,
			edited : false,
			todoshow: "all",
			allChecked : false
		};



		function arrange(filter) {
			switch(filter) {
				case 'all': scope.statusFilter = ''; break;
				case 'active': scope.statusFilter = {completed: false}; break;
			}
		}





		function addTodoHtml(todo, index) {
			var html =  '<li data-index="' + index + '" class="' + (todo.completed ? "completed" : "") + '">\
					<div class="ui-checkbox ui-checkbox-pink">\
	    				<label>\
	    					<input type="checkbox" class="toggle" '  + (todo.completed ? "checked" : "") + '/>\
	    					<span></span>\
	    				</label>\
	    			</div>\
	    			<div class="todo-title"><p>' + todo.title +
    				'</p><form class="todo-edit">\
    					<input type="text"/>\
    				</form>\
    			</div>\
    			<span class="destroy ion ion-close right"></span>\
	    		</li>';

	    	$todoApp.find(".todo-list").append(html);

		}

		function reArrangeIndex() {
			$todoApp.find(".todo-list > li").each(function(i) {
				$(this).data("index", i);
			});
		}


		function removeTodo(e) {
			// e.preventDefault();
			var todo = $(this).parent(),
				isCompleted = todo.find("input.toggle")[0].checked,
				todoNo = todo.index();

			todo.remove();	// jquery remove(), remove the elements and its child
			scope.remainingCount -= isCompleted ? 0 : 1;
			todos.splice(todoNo, 1);
			todoStore.put(todos);
			reArrangeIndex();	// for safe bet
			// console.log($todoApp.find(".todo-list"));	// check indexing debug.
			// how many left ?
			$todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left");
		}

		function toggleCompleted(e) {
			var todo = $(this).parents('li'),
				todoNo = todo.index(),
				isCompleted = this.checked;
			console.log(todoNo);
			scope.remainingCount += isCompleted ? -1 : 1;
			todos[todoNo].completed = isCompleted;
			todoStore.put(todos);
			todo.toggleClass("completed");
			// how many todo left.
			$todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left");
		}

		function markAll() {
			var $todos = $todoApp.find(".todo-list li"),
				rc = 0,
				allChecked = false;
			// Checked if all is completed
			todos.forEach(function(todo) {
				if(!todo.completed) 
					++rc;
			});
			if(rc == 0)
				allChecked = true;


			todos.forEach(function(todo) {
				todo.completed = !allChecked;
			});

			scope.remainingCount = allChecked ? 0 : todos.length;
			todoStore.put(todos);

			// Now html part
			$todos.each(function(i, todo) {
				var $t = $(todo),
					input = $t.find("input.toggle")[0];

				if(allChecked) {
					$(todo).removeClass("completed");
					input.checked = false;
				}
				else {
					$(todo).addClass("completed");
					input.checked = true;
				}
			});

			// how many left todo ?
			$todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left");
		}

		function addTodo(e) {
			e.preventDefault();
			var todoTitle = $(this).children().val();

			scope.newTodo = todoTitle;
			var newTodo = {
				title: scope.newTodo.trim(),
				completed: false
			};
			if(scope.newTodo.length == 0)
				return;
			todos.push(newTodo);
			todoStore.put(todos);
			scope.newTodo = "",
			scope.remainingCount++;
			// add html part
			addTodoHtml(newTodo, (todos.length-1));
			// attach the remove event to newly added todo.
			setTimeout(function() {
				$todoApp.find(".todo-list li:last-child .destroy").on("click touchstart", removeTodo);
			})
			$(this).children().val(""); // reset the input

			// how many left
			$todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left");

		}

		function doneEditing(todo, todoTitle, isCompleted, todoNo) {
			todo.removeClass("editing");
			todoTitle = todoTitle.trim();
			// put in localstorage.
			todos[todoNo].title = todoTitle;
			if(!todoTitle) {
				scope.removeTodo(todo, isCompleted, todoNo);
			}
			todoStore.put(todos);
			todo.find(".todo-title p").html(todoTitle);
		}

		function editTodo(e) {
			var todo = $(this).parent(),
				todoNo = todo.index(),
				stodo = todos[todoNo], 
				isCompleted = stodo.completed;

			todo.addClass("editing");

			$(this).find("input").val(stodo.title.trim()); // conserve the todo
			// when editing done, store it.
			$todoApp.find(".todo-title .todo-edit").on("submit", function(e) {
				e.preventDefault();
				// take final title from input
				var todoTitle = $(this).find("input").val();
				doneEditing(todo, todoTitle, isCompleted, todoNo);
			});

		}

		function clearCompleted() {	
			todos = todos.filter(function(val) {
				return !val.completed;
			});
			todoStore.put(todos);

			// now html part.
			var $todos = $todoApp.find(".todo-list li").filter(function(i, todo) {
				return $(todo).hasClass("completed");
			});
			$todos.remove();

		}

		// add demo (local storage) todos on the dom load 
		todos.forEach(function(todo, index) {
			addTodoHtml(todo, index);
		});
		// how many todo left.
		$todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left");

		/** ALL EVENTS HERE */

		// destroy the todo
		$todoApp.find(".destroy").on("click touchstart", removeTodo);

		// toggle todo
		$todoApp.find("li input.toggle").on("change", toggleCompleted);

		// Add the todo
		$todoApp.find("#input-todo").on("submit",addTodo);

		// edit the todo
		$todoApp.find(".todo-title").on("dblclick", editTodo);

		// Mark/Unmark All Todo
		$todoApp.find(".todo-foot .toggle-all").on("click touchstart", markAll);

		// clear all completed todos
		$todoApp.find(".todo-foot .clear-completed").on("click touchstart", clearCompleted);

	}



	function _init() {
		initSparklines();
		initC3Chart();
		initEasyPieChart();
		initRating();
		TodoApp();
	}
	_init();

})