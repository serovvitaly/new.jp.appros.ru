<div class="fu-example section">
    <div class="repeater" data-staticheight="800" id="myRepeater">
        <div class="repeater-header">
            <div class="repeater-header-left">
                <span class="repeater-title">Awesome Repeater</span>
                <div class="repeater-search">
                    <div class="search input-group">
                        <input type="search" class="form-control" placeholder="Search"/>
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="sr-only">Search</span>
                </button>
              </span>
                    </div>
                </div>
            </div>
            <div class="repeater-header-right">
                <div class="btn-group selectlist repeater-filters" data-resize="auto">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="selected-label">&nbsp;</span>
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Filters</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li data-value="all" data-selected="true"><a href="#">all</a></li>
                        <li data-value="bug"><a href="#">bug</a></li>
                        <li data-value="dark"><a href="#">dark</a></li>
                        <li data-value="dragon"><a href="#">dragon</a></li>
                        <li data-value="electric"><a href="#">electric</a></li>
                        <li data-value="fairy"><a href="#">fairy</a></li>
                        <li data-value="fighting"><a href="#">fighting</a></li>
                        <li data-value="fire"><a href="#">fire</a></li>
                        <li data-value="flying"><a href="#">flying</a></li>
                        <li data-value="ghost"><a href="#">ghost</a></li>
                        <li data-value="grass"><a href="#">grass</a></li>
                        <li data-value="ground"><a href="#">ground</a></li>
                        <li data-value="ice"><a href="#">ice</a></li>
                        <li data-value="normal"><a href="#">normal</a></li>
                        <li data-value="poison"><a href="#">poison</a></li>
                        <li data-value="psychic"><a href="#">psychic</a></li>
                        <li data-value="rock"><a href="#">rock</a></li>
                        <li data-value="steel"><a href="#">steel</a></li>
                        <li data-value="water"><a href="#">water</a></li>
                    </ul>
                    <input class="hidden hidden-field" name="filterSelection" readonly="readonly" aria-hidden="true" type="text"/>
                </div>
                <div class="btn-group repeater-views" data-toggle="buttons">
                    <label class="btn btn-default active">
                        <input name="repeaterViews" type="radio" value="list"><span class="glyphicon glyphicon-list"></span>
                    </label>
                    <label class="btn btn-default">
                        <input name="repeaterViews" type="radio" value="thumbnail"><span class="glyphicon glyphicon-th"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="repeater-viewport">
            <div class="repeater-canvas"></div>
            <div class="loader repeater-loader"></div>
        </div>
        <div class="repeater-footer">
            <div class="repeater-footer-left">
                <div class="repeater-itemization">
                    <span><span class="repeater-start"></span> - <span class="repeater-end"></span> of <span class="repeater-count"></span> items</span>
                    <div class="btn-group selectlist" data-resize="auto">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="selected-label">&nbsp;</span>
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li data-value="5"><a href="#">5</a></li>
                            <li data-value="10" data-selected="true"><a href="#">10</a></li>
                            <li data-value="20"><a href="#">20</a></li>
                            <li data-value="50" data-foo="bar" data-fizz="buzz"><a href="#">50</a></li>
                            <li data-value="100"><a href="#">100</a></li>
                        </ul>
                        <input class="hidden hidden-field" name="itemsPerPage" readonly="readonly" aria-hidden="true" type="text"/>
                    </div>
                    <span>Per Page</span>
                </div>
            </div>
            <div class="repeater-footer-right">
                <div class="repeater-pagination">
                    <button type="button" class="btn btn-default btn-sm repeater-prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous Page</span>
                    </button>
                    <label class="page-label" id="myPageLabel">Page</label>
                    <div class="repeater-primaryPaging active">
                        <div class="input-group input-append dropdown combobox">
                            <input type="text" class="form-control" aria-labelledby="myPageLabel">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"></ul>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control repeater-secondaryPaging" aria-labelledby="myPageLabel">
                    <span>of <span class="repeater-pages"></span></span>
                    <button type="button" class="btn btn-default btn-sm repeater-next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next Page</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#myRepeater').repeater({
            dataSource: function(options, callback){
                $.ajax({
                    url: '/rest/grid',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        controller: 'ProductsController',
                        options: options
                    },
                    success: callback
                });
            }
        });
    });
</script>