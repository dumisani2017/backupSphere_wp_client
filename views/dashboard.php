<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2/15/2018
 * Time: 12:16 PM
 */
    require_once(BACKUPSHERE__PLUGIN_DIR . 'libs/clsBackupSphere.php') ;

    $backupShere = new clsBackupSphere();

    $backupShere->databaseDirectory();

    foreach ($backupShere->queryTables() as $foundTables) {

        foreach ($foundTables as $table) {   

            $backupShere->create_csv($table, $backupShere->queryTableData($table));

        }
    }

    $backupShere->create_dbSchema_txt();    

    $backupShere->Zip($backupShere->files_path, $backupShere->files_path .".zip");


    $admin_email = get_option('admin_email');

    $backupShere->insert_to_backupShere( $admin_email , 0, 0);     

    
?>

    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {height: 450px}

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height:auto;}
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Logo</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-12 text-left">
                <h1>Welcome</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur
                    sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur
                    adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <hr>

                <button type="button" class="btn btn-default">Create Back Up</button>
                <button type="button" class="btn btn-success">Restore last Back Up</button>

                <hr>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Time stamp</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td><script> document.write(new Date().toDateString()); </script></td>
                        <td>Success</td>
                        <td><button type="button" class="btn btn-success">Restore</button> <button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Mary</td>
                        <td>Moe</td>
                        <td><script> document.write(new Date().toDateString()); </script></td>
                        <td>Success</td>
                        <td><button type="button" class="btn btn-success">Restore</button> <button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td>July</td>
                        <td>Dooley</td>
                        <td><script> document.write(new Date().toDateString()); </script></td>
                        <td>Success</td>
                        <td><button type="button" class="btn btn-success">Restore</button> <button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<footer class="container-fluid text-center">
    <p>backupShere</p>
</footer>
</body>
</html>

<script type="text/javascript">
    $('document').ready(function(){
        //alert('we are on');
    });
</script>