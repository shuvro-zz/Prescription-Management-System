<form method="post" accept-charset="utf-8" id="venues-form" class="form-horizontal" novalidate="novalidate" enctype="multipart/form-data" action="/admin/venues/add" autocomplete="off"><div id="autocomplete_off" style="height: 0px !important; width: 0px !important; margin-left: -1700px !important; overflow: hidden !important; position: fixed !important;"><input style="display:none"><input style="" type="password"><input autocomplete="chrome" type="text"></div><div style="display:none;"><input name="_method" value="POST" autocomplete="off" type="hidden"></div><section class="workspace">
        <div class="workspace-body">
            <div class="page-heading">
                <ol class="breadcrumb breadcrumb-small">
                    <li><a href="http://organization.gradpak.com/admin/dashboard">Dashboard</a></li>
                    <li class="active"><a href="#">Add Venues</a></li>
                </ol>
            </div>
            <div class="main-container">
                <div class="content">
                    <div class="page-wrap">

                        <div class="col-md-12">
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default panel-hovered panel-stacked">
                                        <div class="panel-heading">Add Venues </div>
                                        <div class="panel-body">


                                            <div class="col-sm-6">
                                                <div class="form-row">
                                                    <label class="name">Title<span class="required" aria-required="true">*</span></label>
                                                    <div class="inputs">
                                                        <div class="input text"><input name="title" class="form-control" maxlength="100" id="title" autocomplete="off" type="text"></div>                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-row">
                                                    <label class="name">Location Name<span class="required" aria-required="true"></span></label>
                                                    <div class="inputs">
                                                        <div class="input text"><input name="location_name" class="form-control" maxlength="255" id="location-name" autocomplete="off" type="text"></div>                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <footer class="footer ">
            <div class="flex-container">
                <a href="/admin/venues" class="btn btn-default  btn-cancel" >Cancel</a>

                <div class="flex-item">
                    <button type="submit" class="btn save event-save">Submit</button>
                </div>
            </div>
        </footer>
    </section>
</form>