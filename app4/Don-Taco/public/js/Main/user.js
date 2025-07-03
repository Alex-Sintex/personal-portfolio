var myApp = angular.module("myModule", ["ngAnimate", "ngAria"]);
myApp.controller("myController", function ($scope, $timeout) {
    // Theme management
    $scope.theme = localStorage.getItem("theme") || "light";
    $scope.toggleTheme = function () {
        $scope.theme = $scope.theme === "light" ? "dark" : "light";
        document.body.setAttribute("data-theme", $scope.theme);
        localStorage.setItem("theme", $scope.theme);
        showNotification("Theme changed to " + $scope.theme + " mode", "info");
    };

    // Apply theme on load
    document.body.setAttribute("data-theme", $scope.theme);

    // View mode management
    $scope.viewMode = localStorage.getItem("viewMode") || "list";
    $scope.setViewMode = function (mode) {
        $scope.viewMode = mode;
        localStorage.setItem("viewMode", mode);
        showNotification("View changed to " + mode + " mode", "info");
    };

    // Pagination settings
    $scope.currentPage = 0;
    $scope.itemsPerPage = localStorage.getItem("itemsPerPage") || 10;
    $scope.pageSizeOptions = [5, 10, 20, 50, 100];

    $scope.pageCount = function () {
        return Math.ceil($scope.filteredEmployees.length / $scope.itemsPerPage);
    };

    $scope.setPage = function (page) {
        if (page >= 0 && page < $scope.pageCount()) {
            $scope.currentPage = page;
        }
    };

    $scope.getPages = function () {
        var pages = [];
        var startPage, endPage;
        var visiblePages = 5;

        if ($scope.pageCount() <= visiblePages) {
            startPage = 0;
            endPage = $scope.pageCount() - 1;
        } else {
            if ($scope.currentPage <= Math.floor(visiblePages / 2)) {
                startPage = 0;
                endPage = visiblePages - 1;
            } else if (
                $scope.currentPage >=
                $scope.pageCount() - Math.floor(visiblePages / 2)
            ) {
                startPage = $scope.pageCount() - visiblePages;
                endPage = $scope.pageCount() - 1;
            } else {
                startPage = $scope.currentPage - Math.floor(visiblePages / 2);
                endPage = $scope.currentPage + Math.floor(visiblePages / 2);
            }
        }

        for (var i = startPage; i <= endPage; i++) {
            pages.push(i);
        }

        return pages;
    };

    $scope.resetPagination = function () {
        $scope.currentPage = 0;
    };

    // Employee data
    $scope.loading = false;
    $scope.maxDob = new Date();
    $scope.maxDob.setFullYear($scope.maxDob.getFullYear() - 18);
    $scope.today = new Date();

    // Load employees from localStorage or initialize with default data
    var storedEmployees = localStorage.getItem("employees");
    if (storedEmployees) {
        $scope.employees = JSON.parse(storedEmployees);
        // Convert string dates back to Date objects
        $scope.employees.forEach(function (employee) {
            employee.dob = new Date(employee.dob);
            if (employee.joinDate) employee.joinDate = new Date(employee.joinDate);
        });
    } else {
        // Default employee data
        $scope.employees = [
            {
                name: "Nunaram",
                dob: new Date("Oct 15, 2001"),
                email: "nuna@gmail.com",
                gender: "Male",
                position: "Web Developer",
                salary: 50000,
                photo: "http://musiklemon.com/admin/upload/bigthumb/559bdc0572c78.jpg",
                quote: 'I like the term "misunderstood". But I am a bit of a bad boy.',
                department: "IT",
                joinDate: new Date("Jan 10, 2020"),
                status: "Active",
                phone: "+44 1234 567890"
            },
            {
                name: "Peter",
                dob: new Date("Nov 16, 2001"),
                email: "peter@gmail.com",
                gender: "Male",
                position: "Marketing Manager",
                salary: 50050,
                photo:
                    "https://img2.lsistatic.com/img/artists/p5rlm/thumb_76894624.jpg",
                quote:
                    "Gucci Gang, Gucci Gang, Gucci Gang, spend 10 racks on a new chain.",
                department: "Marketing",
                joinDate: new Date("Mar 15, 2019"),
                status: "Active",
                phone: "+44 1234 567891"
            },
            {
                name: "Nistha",
                dob: new Date("Dec 17, 2001"),
                email: "Nistha@gmail.com",
                gender: "Female",
                position: "HR Manager",
                salary: 50600,
                photo:
                    "https://yt3.ggpht.com/-MMpZ-Xa8YOo/AAAAAAAAAAI/AAAAAAAAAAA/JQFGBXpmgeA/s100-mo-c-c0xffffffff-rj-k-no/photo.jpg",
                quote: "I never dreamed about success. I worked for it always.",
                department: "HR",
                joinDate: new Date("Jul 22, 2018"),
                status: "Active",
                phone: "+44 1234 567892"
            },
            {
                name: "Tamanna",
                dob: new Date("Dec 18, 2005"),
                email: "tamanna@gmail.com",
                gender: "Female",
                position: "Web & Graphic Designer",
                salary: 50800,
                photo:
                    "http://www.filmofilia.com/wp-content/uploads/2010/04/Selena-Gomez-100x100.jpg",
                quote:
                    "Happiness and confidence are the prettiest things you can wear.",
                department: "IT",
                joinDate: new Date("Sep 5, 2021"),
                status: "Active",
                phone: "+44 1234 567893"
            },
            {
                name: "John Smith",
                dob: new Date("Jan 10, 1990"),
                email: "john.smith@example.com",
                gender: "Male",
                position: "Senior Developer",
                salary: 75000,
                photo: "https://randomuser.me/api/portraits/men/32.jpg",
                quote: "The only way to do great work is to love what you do.",
                department: "IT",
                joinDate: new Date("Feb 28, 2017"),
                status: "Active",
                phone: "+44 1234 567894"
            },
            {
                name: "Emily Johnson",
                dob: new Date("Mar 15, 1992"),
                email: "emily.j@example.com",
                gender: "Female",
                position: "UX Designer",
                salary: 68000,
                photo: "https://randomuser.me/api/portraits/women/44.jpg",
                quote:
                    "Design is not just what it looks like and feels like. Design is how it works.",
                department: "IT",
                joinDate: new Date("Apr 17, 2019"),
                status: "Active",
                phone: "+44 1234 567895"
            },
            {
                name: "Michael Brown",
                dob: new Date("Jul 22, 1985"),
                email: "michael.b@example.com",
                gender: "Male",
                position: "Project Manager",
                salary: 85000,
                photo: "https://randomuser.me/api/portraits/men/75.jpg",
                quote: "Plans are nothing; planning is everything.",
                department: "IT",
                joinDate: new Date("Jun 8, 2016"),
                status: "Active",
                phone: "+44 1234 567896"
            },
            {
                name: "Sarah Wilson",
                dob: new Date("Sep 5, 1988"),
                email: "sarah.w@example.com",
                gender: "Female",
                position: "Marketing Director",
                salary: 92000,
                photo: "https://randomuser.me/api/portraits/women/68.jpg",
                quote:
                    "Marketing is no longer about the stuff you make, but about the stories you tell.",
                department: "Marketing",
                joinDate: new Date("Aug 12, 2015"),
                status: "Active",
                phone: "+44 1234 567897"
            },
            {
                name: "David Lee",
                dob: new Date("Feb 28, 1993"),
                email: "david.lee@example.com",
                gender: "Male",
                position: "Data Analyst",
                salary: 62000,
                photo: "https://randomuser.me/api/portraits/men/12.jpg",
                quote: "Without data, you're just another person with an opinion.",
                department: "Finance",
                joinDate: new Date("Oct 15, 2020"),
                status: "Pending",
                phone: "+44 1234 567898"
            },
            {
                name: "Jennifer Davis",
                dob: new Date("Apr 17, 1991"),
                email: "jennifer.d@example.com",
                gender: "Female",
                position: "Content Writer",
                salary: 58000,
                photo: "https://randomuser.me/api/portraits/women/33.jpg",
                quote: "Words are, of course, the most powerful drug used by mankind.",
                department: "Marketing",
                joinDate: new Date("Nov 16, 2019"),
                status: "Active",
                phone: "+44 1234 567899"
            },
            {
                name: "Robert Taylor",
                dob: new Date("Jun 8, 1987"),
                email: "robert.t@example.com",
                gender: "Male",
                position: "System Administrator",
                salary: 72000,
                photo: "https://randomuser.me/api/portraits/men/89.jpg",
                quote: "It's not a bug - it's an undocumented feature.",
                department: "IT",
                joinDate: new Date("Dec 17, 2018"),
                status: "Inactive",
                phone: "+44 1234 567800"
            },
            {
                name: "Jessica Martinez",
                dob: new Date("Aug 12, 1994"),
                email: "jessica.m@example.com",
                gender: "Female",
                position: "Sales Executive",
                salary: 65000,
                photo: "https://randomuser.me/api/portraits/women/22.jpg",
                quote:
                    "People don't buy for logical reasons. They buy for emotional reasons.",
                department: "Sales",
                joinDate: new Date("Dec 18, 2020"),
                status: "Active",
                phone: "+44 1234 567801"
            }
        ];
        // Save to localStorage
        localStorage.setItem("employees", JSON.stringify($scope.employees));
    }

    $scope.sortCol = localStorage.getItem("sortCol") || "name";
    $scope.search = {};

    // Save sort column to localStorage when changed
    $scope.$watch("sortCol", function (newVal, oldVal) {
        if (newVal !== oldVal) {
            localStorage.setItem("sortCol", newVal);
        }
    });

    // Save items per page to localStorage when changed
    $scope.$watch("itemsPerPage", function (newVal, oldVal) {
        if (newVal !== oldVal) {
            localStorage.setItem("itemsPerPage", newVal);
            $scope.resetPagination();
        }
    });

    // Calculate total salary
    $scope.getTotalSalary = function () {
        return $scope.employees.reduce(function (total, employee) {
            return total + employee.salary;
        }, 0);
    };

    // Calculate average salary
    $scope.getAverageSalary = function () {
        return $scope.employees.length > 0
            ? $scope.getTotalSalary() / $scope.employees.length
            : 0;
    };

    // Calculate age from date of birth
    $scope.calculateAge = function (dob) {
        if (!dob) return "";
        var birthDate = new Date(dob);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    };

    // Show notification
    function showNotification(message, type) {
        var alertClass = "alert-" + (type || "info");
        var alert = $(
            '<div class="alert ' +
            alertClass +
            ' alert-dismissible fade show shadow-sm animate__animated animate__slideInRight" role="alert">' +
            "<strong>" +
            message +
            "</strong>" +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            "</button>" +
            "</div>"
        );

        $(".noti-box").append(alert);

        // Auto dismiss after 5 seconds
        $timeout(function () {
            alert.addClass("animate__slideOutRight");
            $timeout(function () {
                alert.remove();
            }, 500);
        }, 5000);
    }

    // Add employee
    $scope.addingEmployee = false;
    $scope.addEmployee = function () {
        $scope.addingEmployee = true;

        // Simulate API call delay
        $timeout(function () {
            var newEmployee = {
                name: $scope.name,
                dob: new Date($scope.dob),
                email: $scope.email,
                gender: $scope.gender,
                position: $scope.position,
                department: $scope.department,
                salary: parseFloat($scope.salary),
                photo: $scope.photo || "https://via.placeholder.com/100",
                quote: $scope.quote,
                joinDate: $scope.joinDate ? new Date($scope.joinDate) : new Date(),
                status: "Active",
                phone: $scope.phone
            };

            $scope.employees.push(newEmployee);

            // Save to localStorage
            localStorage.setItem("employees", JSON.stringify($scope.employees));

            // Reset form
            $scope.name = "";
            $scope.dob = "";
            $scope.email = "";
            $scope.gender = "";
            $scope.position = "";
            $scope.department = "";
            $scope.salary = "";
            $scope.photo = "";
            $scope.quote = "";
            $scope.joinDate = "";
            $scope.phone = "";

            $("#addModal").modal("hide");
            showNotification(newEmployee.name + " added successfully!", "success");
            $scope.addingEmployee = false;
        }, 1000);
    };

    // Get employee index by name
    $scope.getIndex = function (name) {
        for (var i = 0; i < $scope.employees.length; i++) {
            if ($scope.employees[i].name === name) {
                return i;
            }
        }
        return -1;
    };

    // View employee details
    $scope.viewDetails = function (name) {
        var index = $scope.getIndex(name);
        if (index !== -1) {
            var employee = $scope.employees[index];
            $scope.name3 = employee.name;
            $scope.dob3 = new Date(employee.dob);
            $scope.email3 = employee.email;
            $scope.gender3 = employee.gender;
            $scope.position3 = employee.position;
            $scope.department3 = employee.department;
            $scope.salary3 = employee.salary;
            $scope.photo3 = employee.photo || "https://via.placeholder.com/300";
            $scope.quote3 = employee.quote;
            $scope.joinDate3 = employee.joinDate;
            $scope.status3 = employee.status || "Active";
            $scope.phone3 = employee.phone;
        }
    };

    // Fetch employee details for edit
    $scope.employeeToEdit = null;
    $scope.fetchDetails = function (name) {
        var index = $scope.getIndex(name);
        if (index !== -1) {
            var employee = $scope.employees[index];
            $scope.name2 = employee.name;
            $scope.dob2 = new Date(employee.dob);
            $scope.email2 = employee.email;
            $scope.gender2 = employee.gender;
            $scope.position2 = employee.position;
            $scope.department2 = employee.department;
            $scope.salary2 = employee.salary;
            $scope.photo2 = employee.photo;
            $scope.quote2 = employee.quote;
            $scope.joinDate2 = employee.joinDate ? new Date(employee.joinDate) : "";
            $scope.status2 = employee.status || "Active";
            $scope.phone2 = employee.phone;
            $scope.employeeToEdit = employee.name;
        }
    };

    // Update employee
    $scope.updatingEmployee = false;
    $scope.updateEmployee = function () {
        $scope.updatingEmployee = true;

        // Simulate API call delay
        $timeout(function () {
            var index = $scope.getIndex($scope.employeeToEdit);
            if (index !== -1) {
                $scope.employees[index].name = $scope.name2;
                $scope.employees[index].dob = new Date($scope.dob2);
                $scope.employees[index].email = $scope.email2;
                $scope.employees[index].gender = $scope.gender2;
                $scope.employees[index].position = $scope.position2;
                $scope.employees[index].department = $scope.department2;
                $scope.employees[index].salary = parseFloat($scope.salary2);
                $scope.employees[index].photo =
                    $scope.photo2 || "https://via.placeholder.com/100";
                $scope.employees[index].quote = $scope.quote2;
                $scope.employees[index].joinDate = $scope.joinDate2
                    ? new Date($scope.joinDate2)
                    : new Date();
                $scope.employees[index].status = $scope.status2 || "Active";
                $scope.employees[index].phone = $scope.phone2;

                // Save to localStorage
                localStorage.setItem("employees", JSON.stringify($scope.employees));

                $("#editModal").modal("hide");
                showNotification($scope.name2 + " updated successfully!", "success");
            }
            $scope.updatingEmployee = false;
        }, 1000);
    };

    // Toggle employee status
    $scope.toggleEmployeeStatus = function (employee) {
        var newStatus = employee.status === "Inactive" ? "Active" : "Inactive";
        if (
            confirm(
                "Are you sure you want to " +
                (newStatus === "Active" ? "activate" : "deactivate") +
                " " +
                employee.name +
                "?"
            )
        ) {
            employee.status = newStatus;

            // Save to localStorage
            localStorage.setItem("employees", JSON.stringify($scope.employees));

            showNotification(
                employee.name + " status changed to " + newStatus,
                "info"
            );
        }
    };

    // Print employee
    $scope.printEmployee = function () {
        var printContent = `
      <div class="print-content" style="padding: 20px; max-width: 800px; margin: 0 auto;">
        <h2 style="text-align: center; margin-bottom: 30px; color: var(--primary-color);">Employee Details</h2>
        <div style="display: flex; margin-bottom: 30px;">
          <div style="flex: 1; text-align: center;">
            <img src="${$scope.photo3 || "https://via.placeholder.com/200"
            }" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 5px solid var(--primary-color);">
          </div>
          <div style="flex: 2; padding-left: 30px;">
            <h3 style="margin-top: 0;">${$scope.name3}</h3>
            <h4 style="color: #666; margin-top: 5px;">${$scope.position3}</h4>
            <p><strong>Email:</strong> ${$scope.email3}</p>
            <p><strong>Phone:</strong> ${$scope.phone3 || "N/A"}</p>
            <p><strong>Date of Birth:</strong> ${moment($scope.dob3).format(
                "DD MMMM YYYY"
            )} (Age: ${$scope.calculateAge($scope.dob3)})</p>
            <p><strong>Gender:</strong> ${$scope.gender3}</p>
            <p><strong>Department:</strong> ${$scope.department3 || "N/A"}</p>
            <p><strong>Join Date:</strong> ${moment($scope.joinDate3).format(
                "DD MMMM YYYY"
            )}</p>
            <p><strong>Status:</strong> ${$scope.status3 || "Active"}</p>
            <p><strong>Salary:</strong> ${$scope.salary3.toLocaleString(
                "en-GB",
                { style: "currency", currency: "GBP" }
            )}</p>
          </div>
        </div>
        <div style="margin-top: 20px;">
          <h4 style="border-bottom: 2px solid var(--primary-color); padding-bottom: 5px;">About</h4>
          <blockquote style="font-style: italic; padding: 10px 20px; background: #f8f9fa; border-left: 4px solid var(--primary-color);">
            <p>${$scope.quote3}</p>
            <footer style="text-align: right;">— ${$scope.name3}</footer>
          </blockquote>
        </div>
        <div style="text-align: center; margin-top: 40px; font-size: 12px; color: #666;">
          <p>Generated on ${moment().format("DD MMMM YYYY [at] HH:mm")}</p>
        </div>
      </div>
    `;

        var win = window.open("", "", "width=800,height=600");
        win.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
        <title>Employee Details - ${$scope.name3}</title>
        <style>
          body { font-family: 'Poppins', sans-serif; padding: 20px; }
          h2 { color: #4361ee; }
          img { border: 5px solid #4361ee; }
          blockquote { border-left: 4px solid #4361ee; }
        </style>
      </head>
      <body>
        ${printContent}
        <script>
          setTimeout(function() { 
            window.print(); 
            setTimeout(function() { window.close(); }, 500);
          }, 500);
        <\/script>
      </body>
      </html>
    `);
        win.document.close();
    };

    // Export employee data
    $scope.exportEmployee = function () {
        var employeeData = {
            name: $scope.name3,
            position: $scope.position3,
            department: $scope.department3,
            email: $scope.email3,
            phone: $scope.phone3,
            dob: moment($scope.dob3).format("DD/MM/YYYY"),
            age: $scope.calculateAge($scope.dob3),
            gender: $scope.gender3,
            status: $scope.status3,
            joinDate: moment($scope.joinDate3).format("DD/MM/YYYY"),
            salary: $scope.salary3.toLocaleString("en-GB", {
                style: "currency",
                currency: "GBP"
            }),
            quote: $scope.quote3,
            photo: $scope.photo3 || "No photo available"
        };

        var dataStr =
            "data:text/json;charset=utf-8," +
            encodeURIComponent(JSON.stringify(employeeData, null, 2));
        var downloadAnchorNode = document.createElement("a");
        downloadAnchorNode.setAttribute("href", dataStr);
        downloadAnchorNode.setAttribute(
            "download",
            $scope.name3.replace(/\s+/g, "_") + "_employee_data.json"
        );
        document.body.appendChild(downloadAnchorNode);
        downloadAnchorNode.click();
        downloadAnchorNode.remove();

        showNotification($scope.name3 + "'s data exported successfully!", "info");
    };

    // Export all data
    $scope.exportAllData = function () {
        var dataStr =
            "data:text/json;charset=utf-8," +
            encodeURIComponent(JSON.stringify($scope.employees, null, 2));
        var downloadAnchorNode = document.createElement("a");
        downloadAnchorNode.setAttribute("href", dataStr);
        downloadAnchorNode.setAttribute(
            "download",
            "all_employees_data_" + moment().format("YYYYMMDD") + ".json"
        );
        document.body.appendChild(downloadAnchorNode);
        downloadAnchorNode.click();
        downloadAnchorNode.remove();

        showNotification("All employee data exported successfully!", "info");
    };

    // Initialize tooltips
    $timeout(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Initialize popovers
    $timeout(function () {
        $('[data-toggle="popover"]').popover();
    });
});
