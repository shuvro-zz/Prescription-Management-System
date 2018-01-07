/**
 * Entry point (main) script all the common initialization (plugins, utilities etc).
 */
jQuery(function() {
	"use strict";

	var MateriaApp = function() {
		this.isMobile = null;	// constantly checked via matchMedia.
		// initial value, but these options will not work, if you've already saved state via theme settings panel.
		this.navHorizontal = false;
		this.fixedHeader = true;
		this.themeActive = "theme-zero";
		this.navFull = true;
		this.navOffCanvas = false;
		// common selectors
		this.mainContainer = $(".main-container");
		this.siteHead = $(".site-head");
		this.siteSettings = $(".site-settings");
		this.app = $(".app");
		this.navWrap = $(".nav-wrap");
		this.contentContainer = $(".content-container");
		this._init();
	};

	MateriaApp.prototype._init = function() {
		this._checkMobile();
		this.toggleSiteNav();
		this.initDefaultSettings();
		this.initRipple();
		this.toggleSettingsBox();
		this.initPerfectScrollbars();
		this.toggleFullScreen();
		this.toggleFloatingSidebar();
		this.initNavAccordion();

	};

	// default settings for app like fixedHeader, horizontal nav, active theme etc. 
	// with saved state.
	MateriaApp.prototype.initDefaultSettings = function() {
		var that = this;

		var SETTINGS_STATES = "_setting-states";
		var statesQuery = {
			get : function() {
				return JSON.parse(localStorage.getItem(SETTINGS_STATES));
			},
			put : function(states) {
				localStorage.setItem(SETTINGS_STATES, JSON.stringify(states));
			}
		};

		// initialize the states
		var sQuery = statesQuery.get() || {
			navHorizontal: that.navHorizontal,
			fixedHeader: that.fixedHeader,
			navFull: that.navFull,
			themeActive: that.themeActive
		};
		if(sQuery) {
			this.navHorizontal = sQuery.navHorizontal;
			this.fixedHeader = sQuery.fixedHeader;
			this.navFull = sQuery.navFull;
			this.themeActive = sQuery.themeActive;
		}
		

		function onNavHorizontal() {
			if(this.checked) {
				that.navHorizontal = true;
				that.mainContainer.addClass("nav-horizontal");
			}
			else {
				that.navHorizontal = false;
				that.mainContainer.removeClass("nav-horizontal");
			}
			setTimeout(function() {
				sQuery.navHorizontal = that.navHorizontal;
				statesQuery.put(sQuery);
			});
		}

		function onFixedHeader() {
			if(this.checked) {
				that.fixedHeader = true;
				that.siteHead.addClass("fixedHeader");
				that.contentContainer.addClass("fixedHeader");
			}
			else {
				that.fixedHeader = false;
				that.siteHead.removeClass("fixedHeader");
				that.contentContainer.removeClass("fixedHeader");
			}
			setTimeout(function() {
				sQuery.fixedHeader = that.fixedHeader;
				statesQuery.put(sQuery);
			});
		}

		function onNavFull() {
			var elems = ["body", ".main-container", ".nav-wrap", ".content-container"];
			if(this.checked) {
				that.navFull = true;
				elems.forEach(function(el) {
					$(el).addClass("nav-expand");
				});
			}
			else {
				that.navFull = false;
				elems.forEach(function(el) {
					$(el).removeClass("nav-expand");
				});
			}
			setTimeout(function() {
				sQuery.navFull = that.navFull;
				statesQuery.put(sQuery);
			});
		}

		function onThemeChange(e) {
			var $t = $(this),
				$list = that.siteSettings.find("#themeColor li");
			// add class `active` to new theme switcher
			$list.removeClass("active");

			$t.addClass("active");

			// remove previous class
			that.app.removeClass(that.themeActive); 
			// assign new active theme to variable
			that.themeActive = $t.data("theme");
			// put in saved state
			sQuery.themeActive = that.themeActive;
			statesQuery.put(sQuery);
			// add new class (theme) to app.
			that.app.addClass(that.themeActive);

			e.preventDefault();
		}


		// Now save the settings based on user configuration 
		// from front-end.
		// observe navHorizontal
		this.siteSettings.find("#navHorizontal").on("change", onNavHorizontal);
		// observe fixedHeader
		this.siteSettings.find("#fixedHeader").on("change", onFixedHeader);
		// observe navFull
		this.siteSettings.find("#navFull").on("change", onNavFull);
		// observe theme active
		this.siteSettings.find("#themeColor li").on("click touchstart", onThemeChange);


		// apply this theme initially.
		this.app.addClass(this.themeActive);

		// if we want nav full do this, else nothing.
		if(this.navFull) {
			this.siteSettings.find("#navFull")[0].checked = true;
			var elems = ["body", ".main-container", ".nav-wrap", ".content-container"];
			elems.forEach(function(el) {
				$(el).addClass("nav-expand");
			});
		} 

		// if we want nav horizontal do this, else nothing
		if(this.navHorizontal) {
			this.siteSettings.find("#navHorizontal")[0].checked = true;
			this.mainContainer.addClass("nav-horizontal");
		}

		// if we want fixed header do this, else nothing
		if(this.fixedHeader) {
			this.siteSettings.find("#fixedHeader")[0].checked = true;
			this.siteHead.addClass("fixedHeader");
			this.contentContainer.addClass("fixedHeader");
		}

		// if nav is offcanvas is true (usually in mobile view)
		if(this.navOffCanvas) {
			this.navWrap.addClass("nav-offcanvas");
		}

	};


	MateriaApp.prototype.initRipple = function() {
		Waves.attach(".btn");
		Waves.init({
			duration: 900,
			delay: 300
		});
		Waves.attach(".nav-wrap .site-nav .nav-list li");
		// Md buttons
		Waves.attach(".md-button:not(.md-no-ink)");
	}


	MateriaApp.prototype._checkMobile = function() {
		// private function, instead use variable `isMobile`.
		var mm = window.matchMedia("(max-width: 767px)");
		this.isMobile = mm.matches ? true : false;
		var that = this;
		mm.addListener(function(m) {
			that.isMobile = (m.matches) ? true : false;
		});

	};

	//Site Nav trigger 
	MateriaApp.prototype.toggleSiteNav = function() {
		this.siteHead.find(".nav-trigger").on("click touchstart", function(e) {
			var elems = ["body", ".main-container", ".nav-wrap", ".content-container"];
			elems.forEach(function(el) {
				$(el).toggleClass("nav-expand");
				if(el == ".nav-wrap") {
					$(el).toggleClass("nav-offcanvas");
				}

			});

			e.preventDefault();
		});

	};

	// toggle theme settings Box
	MateriaApp.prototype.toggleSettingsBox = function() {
		this.siteSettings.find(".trigger").on("click touchstart", function(e) {
			$(".site-settings").toggleClass("open");
			e.preventDefault();
		})
	};


	// Init Perfect Scrollbars
	MateriaApp.prototype.initPerfectScrollbars = function() {
		var $el = $("[data-perfect-scrollbar]");
		
		$el.each(function(i, el){
			var $t = $(this);
			$t.perfectScrollbar({
				suppressScrollX: true
			});
			
			setInterval(function() {
				if($t[0].scrollHeight >= $t[0].clientHeight)
					$t.perfectScrollbar("update");
			}, 400);
		});
	};


	// toggle FullScreen
	MateriaApp.prototype.toggleFullScreen = function() {
		$(".site-head .fullscreen").on("click", function(e) {
			screenfull.toggle();
			e.preventDefault();
		});
	};

	// toggle floating sidebar
	MateriaApp.prototype.toggleFloatingSidebar = function() {
		$(".site-head .floating-sidebar > a").on("click", function(e) {
			$(this).parent().toggleClass("open");
			e.preventDefault();
		});
	};

	// Site Nav Accordion
	MateriaApp.prototype.initNavAccordion = function() {
		var el = $(".site-nav .nav-list"),
			lists = el.find("ul").parent("li"), 	// target li which has sub ul
			a = lists.children("a"),
			aul = lists.find("ul a"),
			listsRest = el.children("li").not(lists),
			aRest = listsRest.children("a"),
			stopClick = 0,
			that = this;	

			
		a.on("click", function(e) {
			if(!that.navHorizontal) {
				if(e.timeStamp - stopClick > 300) {
					var self = $(this),
						parent = self.parent("li");
					// remove `open` class from all
					lists.not(parent).removeClass("open");
					parent.toggleClass("open");
					stopClick = e.timeStamp;
				}
				e.preventDefault();
			}
			e.stopPropagation();
			e.stopImmediatePropagation();
		});
		
		aul.on("touchend", function(e) {
			if(that.isMobile) {
				that.navWrap.toggleClass("nav-offcanvas");

			}
			e.stopPropagation();
			e.stopImmediatePropagation();
		})

		aRest.on("touchend", function() {
			if(that.isMobile) {
				that.navWrap.toggleClass("nav-offcanvas");
			}
		})

		// slide up nested nav when clicked on aRest
		aRest.on("click", function(e) {
			if(!that.navHorizontal) {
				var parent = aRest.parent("li");
				lists.not(parent).removeClass("open");
				
			}
			e.stopPropagation();
			e.stopImmediatePropagation();
		});

	};





	// expose to public
	var materia = window.MateriaApp = new MateriaApp();



});