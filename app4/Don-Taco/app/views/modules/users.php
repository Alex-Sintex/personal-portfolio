<html lang="en" ng-app="myModule">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>User Management</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="<?= PATH_URL; ?>css/Main/user_style.css" type="text/css" />
</head>

<body data-theme="light">
    <div class="container-fluid" ng-controller="myController">
        <div class="row">
            <div class="col-12">
                <div class="cover">
                    <div class="c-overlay"></div>
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-4 font-weight-bold mb-3">User Manager</h1>
                                <p class="lead mb-0">Manage your team efficiently and effectively</p>
                            </div>
                            <button class="theme-toggle" ng-click="toggleTheme()" title="Toggle Dark Mode">
                                <i class="fas" ng-class="{'fa-moon': theme === 'light', 'fa-sun': theme === 'dark'}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card animate__animated animate__fadeIn animate-delay-1">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-value">{{employees.length}}</div>
                        <div class="stats-label">Total Employees</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card animate__animated animate__fadeIn animate-delay-2">
                        <div class="stats-icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="stats-value">{{(employees | filter:{gender:'Male'}).length}}</div>
                        <div class="stats-label">Male Employees</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card animate__animated animate__fadeIn animate-delay-3">
                        <div class="stats-icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="stats-value">{{(employees | filter:{gender:'Female'}).length}}</div>
                        <div class="stats-label">Female Employees</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card animate__animated animate__fadeIn animate-delay-4">
                        <div class="stats-icon">
                            <i class="fas fa-pound-sign"></i>
                        </div>
                        <div class="stats-value">{{getTotalSalary() | currency:"£"}}</div>
                        <div class="stats-label">Total Salary</div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card animate__animated animate__fadeIn">
                        <div class="card-body">
                            <form class="form-inline">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search employees..." ng-model="search.$"
                                        ng-change="resetPagination()">
                                </div>

                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-filter"></i></div>
                                    </div>
                                    <select class="custom-select" ng-model="search.gender" ng-change="resetPagination()">
                                        <option value="">All Genders</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort"></i></div>
                                    </div>
                                    <select class="custom-select" ng-model="sortCol" ng-change="resetPagination()">
                                        <option value="name">Name (A-Z)</option>
                                        <option value="-name">Name (Z-A)</option>
                                        <option value="dob">DOB (Oldest)</option>
                                        <option value="-dob">DOB (Youngest)</option>
                                        <option value="gender">Gender (A-Z)</option>
                                        <option value="-gender">Gender (Z-A)</option>
                                        <option value="salary">Salary (Low-High)</option>
                                        <option value="-salary">Salary (High-Low)</option>
                                    </select>
                                </div>

                                <div class="btn-group mb-2 mr-sm-2" role="group">
                                    <button type="button" class="btn btn-outline-primary" ng-class="{'active': viewMode === 'list'}"
                                        ng-click="setViewMode('list')" title="List View">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" ng-class="{'active': viewMode === 'grid'}"
                                        ng-click="setViewMode('grid')" title="Grid View">
                                        <i class="fas fa-th-large"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" ng-class="{'active': viewMode === 'table'}"
                                        ng-click="setViewMode('table')" title="Table View">
                                        <i class="fas fa-table"></i>
                                    </button>
                                </div>

                                <button class="btn btn-success mb-2" data-toggle="modal" data-target="#addModal"
                                    title="Add New Employee">
                                    <i class="fas fa-plus"></i> Add Employee
                                </button>

                                <button class="btn btn-info mb-2 ml-2" ng-click="exportAllData()" title="Export All Data">
                                    <i class="fas fa-file-export"></i> Export
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div ng-show="loading" class="text-center py-5">
                        <div class="spinner text-primary"></div>
                        <p>Loading employees...</p>
                    </div>

                    <div ng-hide="loading">
                        <!-- List View -->
                        <div ng-show="viewMode === 'list'">
                            <div class="card animate__animated animate__fadeIn">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Gender</th>
                                                    <th>Position</th>
                                                    <th>Salary</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    ng-repeat="employee in filteredEmployees = (employees | orderBy: sortCol | filter:search) | limitTo:itemsPerPage:currentPage*itemsPerPage"
                                                    class="animate__animated animate__fadeIn"
                                                    ng-class="{'animate__delay-1s': $index % 2 === 0, 'animate__delay-2s': $index % 2 !== 0}">
                                                    <td><img ng-src="{{employee.photo || 'https://via.placeholder.com/40'}}"
                                                            alt="{{employee.name}}" class="avatar"
                                                            onerror="this.src='https://via.placeholder.com/40'"></td>
                                                    <td>{{employee.name | uppercase}}</td>
                                                    <td><a href="mailto:{{employee.email}}" class="text-primary">{{employee.email |
                              lowercase}}</a></td>
                                                    <td>
                                                        <span class="badge"
                                                            ng-class="{'badge-primary': employee.gender === 'Male', 'badge-pink': employee.gender === 'Female'}">
                                                            {{employee.gender}}
                                                        </span>
                                                    </td>
                                                    <td>{{employee.position}}</td>
                                                    <td>{{employee.salary | currency:"£"}}</td>
                                                    <td>
                                                        <span class="status-indicator"
                                                            ng-class="{'status-active': employee.status === 'Active', 'status-inactive': employee.status === 'Inactive', 'status-pending': employee.status === 'Pending'}"></span>
                                                        {{employee.status || 'Active'}}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button class="btn btn-info" data-toggle="modal" data-target="#viewModal"
                                                                ng-click="viewDetails(employee.name)" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal"
                                                                ng-click="fetchDetails(employee.name)" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-danger" ng-click="toggleEmployeeStatus(employee)"
                                                                title="{{employee.status === 'Inactive' ? 'Activate' : 'Deactivate'}}">
                                                                <i class="fas"
                                                                    ng-class="{'fa-toggle-on': employee.status === 'Inactive', 'fa-toggle-off': employee.status !== 'Inactive'}"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <select class="custom-select custom-select-sm" style="width: auto;" ng-model="itemsPerPage"
                                                ng-change="resetPagination()" ng-options="option for option in pageSizeOptions">
                                            </select>
                                            <span class="ml-2">items per page</span>
                                        </div>

                                        <div>
                                            <p class="mb-0">Showing {{currentPage*itemsPerPage+1}} to {{(currentPage+1)*itemsPerPage >
                        filteredEmployees.length ? filteredEmployees.length : (currentPage+1)*itemsPerPage}} of
                                                {{filteredEmployees.length}} employees
                                            </p>
                                        </div>

                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                                    <a class="page-link" href ng-click="setPage(0)" title="First"><i
                                                            class="fas fa-angle-double-left"></i></a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                                    <a class="page-link" href ng-click="setPage(currentPage-1)" title="Previous"><i
                                                            class="fas fa-angle-left"></i></a>
                                                </li>
                                                <li class="page-item" ng-repeat="page in getPages() track by $index"
                                                    ng-class="{'active': page === currentPage}">
                                                    <a class="page-link" href ng-click="setPage(page)">{{page+1}}</a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                                    <a class="page-link" href ng-click="setPage(currentPage+1)" title="Next"><i
                                                            class="fas fa-angle-right"></i></a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                                    <a class="page-link" href ng-click="setPage(pageCount()-1)" title="Last"><i
                                                            class="fas fa-angle-double-right"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid View -->
                        <div ng-show="viewMode === 'grid'">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4"
                                    ng-repeat="employee in filteredEmployees = (employees | orderBy: sortCol | filter:search) | limitTo:itemsPerPage:currentPage*itemsPerPage">
                                    <div class="card h-100 animate__animated animate__fadeIn"
                                        ng-class="'animate__delay-' + ($index % 4) + 's'">
                                        <div class="card-body text-center">
                                            <img ng-src="{{employee.photo || 'https://via.placeholder.com/100'}}" alt="{{employee.name}}"
                                                class="card-img-top mb-3" onerror="this.src='https://via.placeholder.com/100'">
                                            <h5 class="card-title">{{employee.name}}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{employee.position}}</h6>
                                            <div class="mb-3">
                                                <span class="badge"
                                                    ng-class="{'badge-primary': employee.gender === 'Male', 'badge-pink': employee.gender === 'Female'}">
                                                    {{employee.gender}}
                                                </span>
                                                <span class="badge ml-1"
                                                    ng-class="{'badge-success': employee.status === 'Active', 'badge-danger': employee.status === 'Inactive', 'badge-warning': employee.status === 'Pending'}">
                                                    {{employee.status || 'Active'}}
                                                </span>
                                            </div>
                                            <p class="card-text text-truncate" title="{{employee.quote}}">{{employee.quote}}</p>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-sm btn-info mx-1" data-toggle="modal" data-target="#viewModal"
                                                    ng-click="viewDetails(employee.name)" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning mx-1" data-toggle="modal" data-target="#editModal"
                                                    ng-click="fetchDetails(employee.name)" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger mx-1" ng-click="toggleEmployeeStatus(employee)"
                                                    title="{{employee.status === 'Inactive' ? 'Activate' : 'Deactivate'}}">
                                                    <i class="fas"
                                                        ng-class="{'fa-toggle-on': employee.status === 'Inactive', 'fa-toggle-off': employee.status !== 'Inactive'}"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <small class="text-muted">
                                                <i class="fas fa-envelope"></i> {{employee.email | lowercase}}<br>
                                                <i class="fas fa-pound-sign"></i> {{employee.salary | currency:"£"}}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <select class="custom-select custom-select-sm" style="width: auto;" ng-model="itemsPerPage"
                                        ng-change="resetPagination()" ng-options="option for option in pageSizeOptions">
                                    </select>
                                    <span class="ml-2">items per page</span>
                                </div>

                                <div>
                                    <p class="mb-0">Showing {{currentPage*itemsPerPage+1}} to {{(currentPage+1)*itemsPerPage >
                    filteredEmployees.length ? filteredEmployees.length : (currentPage+1)*itemsPerPage}} of
                                        {{filteredEmployees.length}} employees
                                    </p>
                                </div>

                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                            <a class="page-link" href ng-click="setPage(0)" title="First"><i
                                                    class="fas fa-angle-double-left"></i></a>
                                        </li>
                                        <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                            <a class="page-link" href ng-click="setPage(currentPage-1)" title="Previous"><i
                                                    class="fas fa-angle-left"></i></a>
                                        </li>
                                        <li class="page-item" ng-repeat="page in getPages() track by $index"
                                            ng-class="{'active': page === currentPage}">
                                            <a class="page-link" href ng-click="setPage(page)">{{page+1}}</a>
                                        </li>
                                        <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                            <a class="page-link" href ng-click="setPage(currentPage+1)" title="Next"><i
                                                    class="fas fa-angle-right"></i></a>
                                        </li>
                                        <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                            <a class="page-link" href ng-click="setPage(pageCount()-1)" title="Last"><i
                                                    class="fas fa-angle-double-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Table View -->
                        <div ng-show="viewMode === 'table'">
                            <div class="card animate__animated animate__fadeIn">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Department</th>
                                                    <th>Salary</th>
                                                    <th>Join Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    ng-repeat="employee in filteredEmployees = (employees | orderBy: sortCol | filter:search) | limitTo:itemsPerPage:currentPage*itemsPerPage"
                                                    class="animate__animated animate__fadeIn"
                                                    ng-class="{'animate__delay-1s': $index % 2 === 0, 'animate__delay-2s': $index % 2 !== 0}">
                                                    <td>{{$index + 1}}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img ng-src="{{employee.photo || 'https://via.placeholder.com/40'}}"
                                                                alt="{{employee.name}}" class="avatar mr-3"
                                                                onerror="this.src='https://via.placeholder.com/40'">
                                                            <div>
                                                                <strong>{{employee.name}}</strong><br>
                                                                <small class="text-muted">{{employee.email}}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{employee.position}}</td>
                                                    <td>{{employee.department || 'N/A'}}</td>
                                                    <td>{{employee.salary | currency:"£"}}</td>
                                                    <td>{{employee.joinDate | date:'dd/MM/yyyy'}}</td>
                                                    <td>
                                                        <span class="badge"
                                                            ng-class="{'badge-success': employee.status === 'Active', 'badge-danger': employee.status === 'Inactive', 'badge-warning': employee.status === 'Pending'}">
                                                            {{employee.status || 'Active'}}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button class="btn btn-info" data-toggle="modal" data-target="#viewModal"
                                                                ng-click="viewDetails(employee.name)" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal"
                                                                ng-click="fetchDetails(employee.name)" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-danger" ng-click="toggleEmployeeStatus(employee)"
                                                                title="{{employee.status === 'Inactive' ? 'Activate' : 'Deactivate'}}">
                                                                <i class="fas"
                                                                    ng-class="{'fa-toggle-on': employee.status === 'Inactive', 'fa-toggle-off': employee.status !== 'Inactive'}"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <select class="custom-select custom-select-sm" style="width: auto;" ng-model="itemsPerPage"
                                                ng-change="resetPagination()" ng-options="option for option in pageSizeOptions">
                                            </select>
                                            <span class="ml-2">items per page</span>
                                        </div>

                                        <div>
                                            <p class="mb-0">Showing {{currentPage*itemsPerPage+1}} to {{(currentPage+1)*itemsPerPage >
                        filteredEmployees.length ? filteredEmployees.length : (currentPage+1)*itemsPerPage}} of
                                                {{filteredEmployees.length}} employees
                                            </p>
                                        </div>

                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                                    <a class="page-link" href ng-click="setPage(0)" title="First"><i
                                                            class="fas fa-angle-double-left"></i></a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === 0}">
                                                    <a class="page-link" href ng-click="setPage(currentPage-1)" title="Previous"><i
                                                            class="fas fa-angle-left"></i></a>
                                                </li>
                                                <li class="page-item" ng-repeat="page in getPages() track by $index"
                                                    ng-class="{'active': page === currentPage}">
                                                    <a class="page-link" href ng-click="setPage(page)">{{page+1}}</a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                                    <a class="page-link" href ng-click="setPage(currentPage+1)" title="Next"><i
                                                            class="fas fa-angle-right"></i></a>
                                                </li>
                                                <li class="page-item" ng-class="{'disabled': currentPage === pageCount()-1}">
                                                    <a class="page-link" href ng-click="setPage(pageCount()-1)" title="Last"><i
                                                            class="fas fa-angle-double-right"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Employee Modal -->
        <form name="addForm" ng-submit="addForm.$valid && addEmployee()" novalidate>
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add New Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" ng-model="name" required ng-minlength="3"
                                            ng-maxlength="50">
                                        <small class="text-danger" ng-show="addForm.name.$touched && addForm.name.$error.required">Name is
                                            required</small>
                                        <small class="text-danger" ng-show="addForm.name.$touched && addForm.name.$error.minlength">Name
                                            must be at least 3 characters</small>
                                        <small class="text-danger" ng-show="addForm.name.$touched && addForm.name.$error.maxlength">Name
                                            cannot exceed 50 characters</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" ng-model="email" required
                                            ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/">
                                        <small class="text-danger" ng-show="addForm.email.$touched && addForm.email.$error.required">Email
                                            is required</small>
                                        <small class="text-danger" ng-show="addForm.email.$touched && addForm.email.$error.pattern">Please
                                            enter a valid email</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob" ng-model="dob" required
                                            max="{{maxDob | date:'yyyy-MM-dd'}}">
                                        <small class="text-danger" ng-show="addForm.dob.$touched && addForm.dob.$error.required">Date of
                                            Birth is required</small>
                                        <small class="text-danger" ng-show="addForm.dob.$touched && addForm.dob.$error.max">Employee must be
                                            at least 18 years old</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="male" name="gender" class="custom-control-input" ng-model="gender"
                                                    value="Male" required>
                                                <label class="custom-control-label" for="male">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="female" name="gender" class="custom-control-input" ng-model="gender"
                                                    value="Female">
                                                <label class="custom-control-label" for="female">Female</label>
                                            </div>
                                            <small class="text-danger d-block"
                                                ng-show="addForm.gender.$touched && addForm.gender.$error.required">Gender is required</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" ng-model="phone"
                                            ng-pattern="/^[\d\s\-+()]{10,20}$/">
                                        <small class="text-danger" ng-show="addForm.phone.$touched && addForm.phone.$error.pattern">Please
                                            enter a valid phone number</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="position" ng-model="position" required>
                                        <small class="text-danger"
                                            ng-show="addForm.position.$touched && addForm.position.$error.required">Position is
                                            required</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select class="custom-select" id="department" ng-model="department">
                                            <option value="">Select Department</option>
                                            <option value="IT">IT</option>
                                            <option value="HR">Human Resources</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Operations">Operations</option>
                                            <option value="Sales">Sales</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="salary">Salary (£) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="salary" ng-model="salary" required min="0" step="100">
                                        <small class="text-danger"
                                            ng-show="addForm.salary.$touched && addForm.salary.$error.required">Salary is required</small>
                                        <small class="text-danger" ng-show="addForm.salary.$touched && addForm.salary.$error.min">Salary
                                            must be positive</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="joinDate">Join Date</label>
                                        <input type="date" class="form-control" id="joinDate" ng-model="joinDate"
                                            max="{{today | date:'yyyy-MM-dd'}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="photo">Photo URL</label>
                                        <input type="url" class="form-control" id="photo" ng-model="photo"
                                            placeholder="https://example.com/photo.jpg">
                                        <small class="text-muted">Leave blank for default avatar</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="quote">Quote/Bio <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="quote" ng-model="quote" rows="2" required></textarea>
                                        <small class="text-danger" ng-show="addForm.quote.$touched && addForm.quote.$error.required">Quote
                                            is required</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" ng-disabled="addForm.$invalid">
                                <span ng-if="!addingEmployee">Add Employee</span>
                                <span ng-if="addingEmployee">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Adding...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Edit Employee Modal -->
        <form name="editForm" ng-submit="editForm.$valid && updateEmployee()" novalidate>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editName">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="editName" ng-model="name2" required ng-minlength="3"
                                            ng-maxlength="50">
                                        <small class="text-danger"
                                            ng-show="editForm.editName.$touched && editForm.editName.$error.required">Name is required</small>
                                        <small class="text-danger"
                                            ng-show="editForm.editName.$touched && editForm.editName.$error.minlength">Name must be at least 3
                                            characters</small>
                                        <small class="text-danger"
                                            ng-show="editForm.editName.$touched && editForm.editName.$error.maxlength">Name cannot exceed 50
                                            characters</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="editEmail">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="editEmail" ng-model="email2" required
                                            ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/">
                                        <small class="text-danger"
                                            ng-show="editForm.editEmail.$touched && editForm.editEmail.$error.required">Email is
                                            required</small>
                                        <small class="text-danger"
                                            ng-show="editForm.editEmail.$touched && editForm.editEmail.$error.pattern">Please enter a valid
                                            email</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="editDob">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="editDob" ng-model="dob2" required
                                            max="{{maxDob | date:'yyyy-MM-dd'}}">
                                        <small class="text-danger"
                                            ng-show="editForm.editDob.$touched && editForm.editDob.$error.required">Date of Birth is
                                            required</small>
                                        <small class="text-danger"
                                            ng-show="editForm.editDob.$touched && editForm.editDob.$error.max">Employee must be at least 18
                                            years old</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="editMale" name="editGender" class="custom-control-input"
                                                    ng-model="gender2" value="Male" required>
                                                <label class="custom-control-label" for="editMale">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="editFemale" name="editGender" class="custom-control-input"
                                                    ng-model="gender2" value="Female">
                                                <label class="custom-control-label" for="editFemale">Female</label>
                                            </div>
                                            <small class="text-danger d-block"
                                                ng-show="editForm.editGender.$touched && editForm.editGender.$error.required">Gender is
                                                required</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="editPhone">Phone Number</label>
                                        <input type="tel" class="form-control" id="editPhone" ng-model="phone2"
                                            ng-pattern="/^[\d\s\-+()]{10,20}$/">
                                        <small class="text-danger"
                                            ng-show="editForm.editPhone.$touched && editForm.editPhone.$error.pattern">Please enter a valid
                                            phone number</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editPosition">Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="editPosition" ng-model="position2" required>
                                        <small class="text-danger"
                                            ng-show="editForm.editPosition.$touched && editForm.editPosition.$error.required">Position is
                                            required</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="editDepartment">Department</label>
                                        <select class="custom-select" id="editDepartment" ng-model="department2">
                                            <option value="">Select Department</option>
                                            <option value="IT">IT</option>
                                            <option value="HR">Human Resources</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Operations">Operations</option>
                                            <option value="Sales">Sales</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="editSalary">Salary (£) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="editSalary" ng-model="salary2" required min="0"
                                            step="100">
                                        <small class="text-danger"
                                            ng-show="editForm.editSalary.$touched && editForm.editSalary.$error.required">Salary is
                                            required</small>
                                        <small class="text-danger"
                                            ng-show="editForm.editSalary.$touched && editForm.editSalary.$error.min">Salary must be
                                            positive</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="editJoinDate">Join Date</label>
                                        <input type="date" class="form-control" id="editJoinDate" ng-model="joinDate2"
                                            max="{{today | date:'yyyy-MM-dd'}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="editPhoto">Photo URL</label>
                                        <input type="url" class="form-control" id="editPhoto" ng-model="photo2"
                                            placeholder="https://example.com/photo.jpg">
                                        <small class="text-muted">Leave blank for default avatar</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="editQuote">Quote/Bio <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="editQuote" ng-model="quote2" rows="2" required></textarea>
                                        <small class="text-danger"
                                            ng-show="editForm.editQuote.$touched && editForm.editQuote.$error.required">Quote is
                                            required</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" ng-disabled="editForm.$invalid">
                                <span ng-if="!updatingEmployee">Update Employee</span>
                                <span ng-if="updatingEmployee">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- View Employee Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Employee Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img ng-src="{{photo3 || 'https://via.placeholder.com/300'}}" alt="{{name3}}"
                                    class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;"
                                    onerror="this.src='https://via.placeholder.com/300'">
                                <h3>{{name3}}</h3>
                                <h5 class="text-muted">{{position3}}</h5>
                                <div class="mt-3 mb-4">
                                    <span class="badge"
                                        ng-class="{'badge-primary': gender3 === 'Male', 'badge-pink': gender3 === 'Female'}">
                                        {{gender3}}
                                    </span>
                                    <span class="badge ml-1"
                                        ng-class="{'badge-success': status3 === 'Active', 'badge-danger': status3 === 'Inactive', 'badge-warning': status3 === 'Pending'}">
                                        {{status3 || 'Active'}}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" ng-click="printEmployee()" title="Print Employee Details">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    <button class="btn btn-success" ng-click="exportEmployee()" title="Export Employee Data">
                                        <i class="fas fa-file-export"></i> Export
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Personal Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Email:</div>
                                            <div class="col-sm-8"><a href="mailto:{{email3}}">{{email3}}</a></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Phone:</div>
                                            <div class="col-sm-8">{{phone3 || 'N/A'}}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Date of Birth:</div>
                                            <div class="col-sm-8">{{dob3 | date:'dd MMMM yyyy'}} (Age: {{calculateAge(dob3)}})</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Gender:</div>
                                            <div class="col-sm-8">
                                                <span class="badge"
                                                    ng-class="{'badge-primary': gender3 === 'Male', 'badge-pink': gender3 === 'Female'}">
                                                    {{gender3}}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Department:</div>
                                            <div class="col-sm-8">{{department3 || 'N/A'}}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Join Date:</div>
                                            <div class="col-sm-8">{{joinDate3 | date:'dd MMMM yyyy'}}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Salary:</div>
                                            <div class="col-sm-8">{{salary3 | currency:"£"}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">About</h5>
                                    </div>
                                    <div class="card-body">
                                        <blockquote class="blockquote mb-0">
                                            <p>{{quote3}}</p>
                                            <footer class="blockquote-footer">{{name3}}</footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Box -->
        <div class="noti-box"></div>

        <!-- Floating Action Button -->
        <button class="fab" data-toggle="modal" data-target="#addModal" title="Add Employee">
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-animate/1.8.2/angular-animate.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-aria/1.8.2/angular-aria.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js'></script>
    <script src="<?= PATH_URL ?>js/main/user.js"></script>
</body>

</html>