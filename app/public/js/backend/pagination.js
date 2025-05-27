'use strict';

/**
 * Ajax pagination initialization class in tables.
 */
class BasePagination {
    /**
     * @param table - Table id to initialize pagination.
     * @param orderByField - Id of the field in which the name of the field to be sorted is indicated.
     * @param orderTypeField - Field id indicating the type of field to be sorted.
     * @param nameModule - Name of your module.
     * @param nameFunction - Name of the function used to handle pagination in your controller.
     */
    constructor(table, orderByField, orderTypeField, nameModule, nameFunction) {
        this._table = table;
        this._orderBy = orderByField;
        this._orderType = orderTypeField;
        this._nameModule = nameModule;
        this._nameFunction = nameFunction;
    }

    set table(id) {
        this._table = id;
    }

    get table() {
        return this._table;
    }

    set orderBy(id) {
        this._orderBy = id;
    }

    get orderBy() {
        return this._orderBy;
    }

    set orderType(id) {
        this._orderType = id;
    }

    get orderType() {
        return this._orderType;
    }

    set nameModule(value) {
        this._nameModule = value;
    }

    get nameModule() {
        return this._nameModule;
    }

    set nameFunction(value) {
        this._nameFunction = value;
    }

    get nameFunction() {
        return this._nameFunction;
    }

    set filter(value) {
        this._filter = value;
    }

    get filter() {
        return this._filter;
    }
}

class Pagination extends BasePagination {
    initSearch(_this) {
        //search by keywords
        let keywordsField = document.getElementById(_this.table);

        keywordsField.addEventListener('keyup', function () {
            if (_this.filter) {
                load('panel/' + _this._nameModule + '/' + _this._nameFunction,
                    'search=' + this.value,
                    'orderby#' + _this._orderBy,
                    'ordertype#' + _this._orderType,
                    _this.filter);
            } else {
                load('panel/' + _this._nameModule + '/' + _this._nameFunction,
                    'search=' + this.value,
                    'orderby#' + _this._orderBy,
                    'ordertype#' + _this._orderType);
            }

        });
    }

    initSortFields(_this) {
        //change sort field
        let orderBy = document.getElementById(_this._orderBy);
        let orderType = document.getElementById(_this._orderType);
        let sortFields = document.querySelectorAll('.sort-field');

        // field #id, default - '#id'
        let activeField = '#time';
        // can be 'desc' or 'asc', default - 'desc'
        let type = 'desc';

        sortFields.forEach(field => {
            let arrowElement = field.querySelector('.sort-arrows');
            let fontawesomeIcon = arrowElement.querySelector('i');

            let dataSort = arrowElement.getAttribute('data-sort');

            field.addEventListener('click', function (evt) {
                if (activeField !== dataSort) {
                    activeField = dataSort;
                    type = 'desc';
                }

                type = type === 'desc' ? 'asc' : 'desc';
                let newArrowClass = type === 'desc' ? 'fa-sort-up' : 'fa-sort-down';

                sortFields.forEach(elem => {
                    elem.querySelector('i').classList.remove('fa-sort-up', 'fa-sort-down');
                    elem.querySelector('i').classList.add('fa-sort');
                })

                orderBy.value = dataSort;
                orderType.value = type;

                fontawesomeIcon.classList.remove('fa-sort', 'fa-sort-up', 'fa-sort-down');
                fontawesomeIcon.classList.add(newArrowClass);

                if (_this.filter) {
                    load('panel/' + _this._nameModule + '/' + _this._nameFunction,
                        'search#' + _this._table,
                        'orderby#' + _this._orderBy,
                        'ordertype#' + _this._orderType,
                        _this.filter);
                } else {
                    load('panel/' + _this._nameModule + '/' + _this._nameFunction,
                        'search#' + _this._table,
                        'orderby#' + _this._orderBy,
                        'ordertype#' + _this._orderType);
                }
            });
        });
    }

    initialization() {
        let _this = this;
        this.initSearch(_this);
        this.initSortFields(_this);
    }
}
