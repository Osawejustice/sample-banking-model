<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?=$page?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="./" class="lazy">Home</a></li>
                            <?php if (!empty($sub)):?>
                            <li class="breadcrumb-item"><a href="./support" class="lazy">Support</a></li>
                            <?php endif?>
                            <li class="breadcrumb-item active"><?=$page?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <style>
            .content {
                margin-top: 0!important;
                padding: 0!important;
            }
            .content h2 {
                margin: 0;
                padding: 25px 0;
                font-size: 22px;
                border-bottom: 1px solid #ebebeb;
                color: #666666;
            }
            .home .tickets-list {
                display: flex;
                flex-flow: column;
            }
            .home .tickets-list .ticket {
                padding: 15px 0;
                width: 100%;
                word-wrap: break-word;
                border-bottom: 1px solid #ebebeb;
                display: flex;
                text-decoration: none;
            }
            .home .tickets-list .ticket .con {
                display: flex;
                justify-content: center;
                flex-flow: column;
            }
            .home .tickets-list .ticket i {
                text-align: center;
                width: 80px;
                color: #b3b3b3;
            }
            .home .tickets-list .ticket .title {
                font-weight: 600;
                color: #666666;
            }
            .home .tickets-list .ticket .msg {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                max-width: 400px;
                color: #999999;
                font-size: 14px;
            }
            .home .tickets-list .ticket .created {
                flex-grow: 1;
                align-items: flex-end;
                color: #999999;
                font-size: 14px;
            }
            .home .tickets-list .ticket:last-child {
                border-bottom: 0;
            }
            .home .tickets-list .ticket:hover {
                background-color: #fcfcfc;
            }
            .view h2 .open, .view h2 .resolved {
                color: #38b673;
            }
            .view h2 .closed {
                color: #b63838;
            }
            .view .ticket {
                padding: 20px 0;
            }
            .view .ticket {
                padding: 20px 0;
            }
            .view .ticket .created {
                color: gray;
            }
            .view .comments {
                margin-top: 15px;
                border-top: 1px solid #ebebeb;
                padding: 25px 0;
            }
            .view .comments .comment {
                display: flex;
                padding-bottom: 5px;
            }
            .view .comments .comment div {
                display: flex;
                align-items: flex-start;
                justify-content: center;
                width: 70px;
                color: #e6e6e6;
                transform: scaleX(-1);
            }
            .view .comments .comment section {
                margin: 0 0 20px 0;
            }
            .view .comments .comment section span {
                display: flex;
                font-size: 14px;
                padding-bottom: 5px;
                color: gray;
            }
            section.box img {
                display: block;
                max-width: 60%;
                max-height: 70%;
                width: auto;
                height: auto;
            }
            
        </style>

        <?php if (empty($sub)):?>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <a href="javascript:" id="createTicket" class="btn btn-success btn-sm float-right"><i class="ri-add-line"></i> Create Ticket</a>
                </div>
                <!-- /.float-right -->
                <h3 class="card-title">Tickets</h3>
                <!-- /.card-title -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="content home">
                    <div class="tickets-list">
                        <?php
                        foreach ($app->user_tickets($user->id) as $ticket):
                            if ($ticket->status == "open") {
                                $statusText = '<span class="badge badge-success">Open</span>';
                            } elseif ($ticket->status == "resolved") {
                                $statusText = '<span class="badge badge-dark">Resolved</span>';
                            } elseif ($ticket->status == "closed") {
                                $statusText = '<span class="badge badge-danger">Closed</span>';
                            }
                            ?>
                        <a href="./support/<?=$ticket->ticket_id?>" class="ticket lazy">
                            <span class="con" style="font-size: 2em!important">
                                <?php if ($ticket->status == 'open'): ?>
                                <i class="ri-time-line"></i>
                                <?php elseif ($ticket->status == 'resolved'): ?>
                                <i class="ri-check-double-line"></i>
                                <?php elseif ($ticket->status == 'closed'): ?>
                                <i class=" ri-close-circle-line"></i>
                                <?php endif; ?>
                            </span>
                            <span class="con">
                                <span class="title"><?=$ticket->title?> <?=$statusText?></span>
                                <span class="msg"><?=date('F dS, h:ia', strtotime($ticket->created))?></span>
                            </span>
                            <!-- <span class="con created"></span> -->
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true" style="z-index:2000">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">Create Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ticketForm">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" required="" />
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <select name="department" class="form-control">
                                    <option value="">Select department</option>
                                    <?php foreach($app->support_departments() as $dept):?>
                                        <option value="<?=$dept->id?>"><?=$dept->name?></option>
                                    <?php endforeach?>
                                </select>
                                <!-- /#.form-control -->
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="msg" class="form-control summernote"></textarea>
                                <!-- /#.form-control -->
                            </div>
                            <button type="submit" class="btn-block btn btn-primary">Create</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script type="text/javascript">
            $(document).ready(function() {
                $("#createTicket").click(function(event) {
                    $("#ticketModal").modal('show');
                });
                $("#ticketForm").ajaxSubmit({
                    url : "./backend/ticket-actions?action=create",
                    callback_function : function(data) {
                        $("#ticketModal").modal('hide');
                        redirect("./support/"+data.ticket_id, true);
                    }
                })
                <?php if (!empty($_GET['modal'])):?>
                    $("#ticketModal").modal('toggle');
                <?php endif?>
            });
        </script>
        <?php else:?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?=$page?></h5>
                    <!-- /.card-title -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="content view">
                        <h2><?=$ticket->title?> <span class="<?=$ticket->status?>">(<?=$ticket->status?>)</span></h2>

                        <div class="ticket">
                            <p class="created"><?=date('F dS, h:ia', strtotime($ticket->created))?></p>
                            <p class="msg"><?=html_entity_decode($ticket->msg)?></p>
                        </div>

                        <div class="btns">
                            <?php if ($user->type == "admin" && $ticket->status == 'open'):?>
                                <button class="btn btn-danger btn-sm" id="closeTicket" data-action="close" type="button"><i class="ri-close-circle-line"></i> Close</button>
                                <button class="btn btn-success btn-sm" id="resolveTicket" data-action="resolve" type="button"><i class="ri-check-double-line"></i> Resolve</button>
                                <button class="btn btn-dark btn-sm" type="button" onclick="$('#escalateModal').modal('show')"><i class="ri-arrow-up-circle-line"></i> Escalate</button>
                            <?php endif?>
                        </div>

                        <div class="comments">
                            <?php foreach($ticket->comments as $comment):
                                $luser = $app->user($comment->user_id);
                                // if user's comment
                                if ($luser->id == $user->id) {
                                    $userName = "You";
                                } else {
                                    $userName = $luser->name;
                                }
                                // if not user that sent reply
                                if ($comment->user_id != $ticket->user_id) {
                                    $userName = "Support Team";
                                }
                            ?>
                            <div class="comment">
                                <div>
                                    <i class="ri-reply-line" style="font-size: 2em; color: black;"></i>
                                </div>
                                <section class="box">
                                    <span><?=date('F dS, h:ia', strtotime($comment->created))?> (<?=$userName?>)</span>
                                    <?=(html_entity_decode($comment->msg))?>
                                </section>
                                <!-- /.box -->
                            </div>
                            <?php endforeach; ?>

                            <?php if ($ticket->status == "open"):?>
                            <hr>
                            <form id="commentForm">
                                <textarea name="msg" class="summernote"></textarea>
                                <button type="submit" class="btn btn-primary">Send Reply</button>
                                <!-- /.btn btn-primary -->
                            </form>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#commentForm").ajaxSubmit({
                                        url : "./backend/ticket-actions?action=reply",
                                        append : {
                                            ticket_id : "<?=$app->encrypt($ticket->id)?>"
                                        },
                                        callback_function : function(data) {
                                            reload(true);
                                        }
                                    });

                                    $("#closeTicket, #resolveTicket").click(function(event) {
                                        var action = $(this).data('action');
                                        var confirmAction = confirm("Are you sure you want to "+ action +" ticket #<?=$ticket->ticket_id?>");
                                        if (!confirmAction) return false;
                                        var btn = $(this);
                                        btn.addClass("disabled");
                                        btn.attr('disabled', true);

                                        xhrRequest({
                                            url : "./backend/ticket-actions?action="+action,
                                            data : {
                                                ticket_id : "<?=$app->encrypt($ticket->id)?>"
                                            },
                                            done : function(data) {
                                                notyf.success(data.msg);
                                                if (data.error == false) {
                                                    reload(true);
                                                } else {
                                                    btn.removeClass("disabled");
                                                    btn.removeAttr("disabled");
                                                }
                                            }
                                        })
                                        btn.removeClass("disabled");
                                        btn.removeAttr("disabled");
                                    });

                                    $("#escalateForm").ajaxSubmit({
                                        url : "./backend/ticket-actions?action=escalate",
                                        callback_function : function(data) {
                                            reload(true);
                                        }
                                    })
                                });
                            </script>
                            <?php endif?>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="modal fade" id="escalateModal" tabindex="-1" role="dialog" aria-labelledby="escalateModalLabel" aria-hidden="true" style="z-index:2000">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="mySmallModalLabel">Escalate Ticket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="escalateForm">
                                <div class="form-group">
                                    <label>Escalate To</label>
                                    <select name="department" class="form-control" required="">
                                        <option value="">Select department</option>
                                        <?php foreach($app->support_departments() as $dept):
                                            if ($dept->id == $ticket->department) continue;
                                            ?>
                                            <option value="<?=$dept->id?>"><?=$dept->name?></option>
                                        <?php endforeach?>
                                    </select>
                                    <!-- /#.form-control -->
                                </div>
                                <button type="submit" class="btn-block btn btn-primary">Escalate</button>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        <?php endif?>
    </div>
    <!-- container-fluid -->
</div>