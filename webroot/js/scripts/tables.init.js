jQuery(function() {
	"use strict";

	function toggleBasicTableFns() {
		var $btable = $(".basic-table");
		var btns = [".btable-bordered", ".btable-striped", ".btable-condensed", ".btable-hover"];
		btns.forEach(function(btn) {
			$btable.find(btn).on("click touchstart", function(e) {
				var tableClass = $(this).data("table-class");
				e.preventDefault();
				$(this).toggleClass("active");
				$btable.find("table").toggleClass(tableClass);
			});
		});
	}


	function initDataTable() {
		var $dataTable = $(".data-table"),
			$table = $dataTable.find("table");

		// create temp datas
		var datas = [
			{engine: "Gecko", browser: "Firefox 3.0", platform: "Win 98+/OSX.2+", version: 1.7, grade: "A"},
			{engine: "Gecko", browser: "Firefox 5.0", platform: "Win 98+/OSX.2+", version: 1.8, grade: "A"},
			{engine: "KHTML", browser: "Konqureror 3.5", platform: "KDE 3.5", version: 3.5, grade: "A"},
			{engine: "Presto", browser: "Opera 8.0", platform: "Win 95+/OS.2+", version: "-", grade: "A"},
			{engine: "Misc", browser: "IE Mobile", platform: "Windows Mobile 6", version: "-", grade: "C"},
			{engine: "Trident", browser: "IE 5.5", platform: "Win 95+", version: 5, grade: "A"},
			{engine: "Trident", browser: "IE 6", platform: "Win 98+", version: 7, grade: "A"},
			{engine: "Webkit", browser: "Safari 3.0", platform: "OSX.4+", version: 419.3, grade: "A"},
			{engine: "Webkit", browser: "iPod Touch / iPhone", platform: "OSX.4+", version: 420, grade: "B"},
		];

		var prelength = datas.length;
		// generate more random datas
		for(var i = prelength; i < 100; i++) {
			var rand = Math.floor(Math.random()*prelength);
			datas.push(datas[rand]);
		}



		var table = $table.DataTable({
			data : datas,
			columns: [
				{data : 'engine'},
				{data : 'browser'},
				{data : 'platform'},
				{data : 'version'},
				{data : 'grade'}
			],
			searching: true,
			dom: 'rtip',
			pageLength: 10
		});


		// custom search input
		$dataTable.find(".searchInput").on("keyup", function() {
			table.search(this.value).draw();
		});


		// custom select box 
		$dataTable.find(".lengthSelect").on("change", function() {
			table.page.len(this.value).draw();
		});

		// custom styling via jquery
		$dataTable.find(".dataTables_info").css({
			"margin-left": "20px",
			"font-size": "12px"
		});



	}




	function _init() {
		toggleBasicTableFns();
		initDataTable();
	}
	_init();

})