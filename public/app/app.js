
(function($){

    var self = this;

    this.getDataByAjax = function(data){

        var params = {
            dataType: 'html',
            type: 'get'
        };

        $.extend(params, data)

        $.ajax(params);
    }


    this.getProducts = function(success){
        self.getDataByAjax(success);
    }

    this.searchFilter = {
        query: '',
        category: 0
    };
    this.searchFilterIsUpdateStatus = true;

    this.showPreloader = function(target){
        target.html('<div id="loader-wrapper"><div id="loader"></div></div>');
    }
    this.hidePreloader = function(target){
        target.find('#loader-wrapper').remove();
    }

    this.callController = function(controllerName){
        var controllerNameMethod = self.controllers[controllerName];
        if (typeof(controllerNameMethod) == 'undefined') {
            return;
        }
        self.controllers[controllerName]($(item));
    }

    this.setFilterForProductsSearch = function(options){

        if (options.query && options.query == self.searchFilter.query) {
            return;
        }
        if (options.category && options.category == self.searchFilter.category) {
            return;
        }

        $.extend(self.searchFilter, options);
        self.searchFilterIsUpdateStatus = true;
    }

    this.getFilterForProductsSearch = function(){
        return self.searchFilter;
    }

    this.callControllerForContainer = function(containerSelector){
        var controllerName = $(containerSelector).attr('controller');
        if (!controllerName) {
            // TODO: протестировать метод
            return;
        }
        var controllerNameMethod = self.controllers[controllerName];
        if (typeof(controllerNameMethod) == 'undefined') {
            return;
        }
        self.controllers[controllerName]($(containerSelector));
    }

    this.makeControllers = function(){
        $('[controller]').each(function(index, item){
            var controllerName = $(item).attr('controller');
            var controllerNameMethod = self.controllers[controllerName];
            if (typeof(controllerNameMethod) == 'undefined') {
                return;
            }
            self.controllers[controllerName]($(item));
        });
    }

    this.loadCatalog = function(){
        self.callControllerForContainer('#mainProductsListContainer');
    };

    this.controllers = {
        ProductsListController: function(component){
            if (!self.searchFilterIsUpdateStatus) {
                return;
            }
            self.showPreloader(component);
            self.getDataByAjax({
                url: '/catalog',
                data: {
                    filter: self.getFilterForProductsSearch()
                },
                success: function(responseHtml) {
                    self.hidePreloader(component);
                    component.html(responseHtml);
                    self.searchFilterIsUpdateStatus = false;
                }
            });
        },
        MainTopCategoriesListController: function(component){
            component.on('click', function(){return false;});
            component.find('a').on('click', function(){
                self.setFilterForProductsSearch({
                    category: $(this).data('cid')
                });
                self.loadCatalog();
                $('#mainTopCategoriesListButton').click();
                return false;
            });
        },
        MainTopSearchController: function(component){
            var input = component.find('input');

            var search = function(){
                var searchQuery = input.val();
                if (searchQuery == '') {
                    return;
                }
                self.setFilterForProductsSearch({
                    query: searchQuery
                });
                self.loadCatalog();
            }

            input.on('keyup', function(event){
                var code = event.keyCode || event.which;
                if(code != 13) {
                    return;
                }
                search();
            });
            component.find('button').on('click', function(){
                search();
            });
        }
    }

    this.makeControllers();

}(jQuery))
