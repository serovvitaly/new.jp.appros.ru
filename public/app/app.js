
(function($){

    var self = this;

    this.getDataByAjax = function(url, success){
        $.ajax({
            url: url,
            dataType: 'html',
            type: 'get',
            success: success
        });
    }


    this.getProducts = function(success){
        self.getDataByAjax(success);
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

    this.controllers = {
        ProductsListController: function(item){
            self.getDataByAjax('/catalog', function(responseHtml){
                //item.html(responseHtml);
            });
        }
    }

    this.makeControllers();

}(jQuery))
