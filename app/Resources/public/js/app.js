(function($) {
    UI = {
        init: function() {
            
            this.initInteract();
            this.initBtn();
            this.initDatatable();
        },
        addTerm: function(datas) {
            if ($('#botSticky').hasClass('hide')) {
                $('#botSticky').removeClass('hide');
            }

            $('.return-term').append("<div class='zone-term'>");
            $('.return-term').append( datas );
            $('.return-term').append("</div>");

            $("#botSticky").scrollTop($("#botSticky")[0].scrollHeight);
        },
        initInteract: function() {
            var offset = { x: 0, y: 0 };

            interact('#botSticky').resizable({
                edges: { left: true, right: true, bottom: true, top: true }
              }).on('resizemove', function (event) {
                var target = event.target;

                // update the element's style
                target.style.height = event.rect.height + 'px';

                // translate when resizing from top or left edges
                offset.y += event.deltaRect.top;
            });
        },
        initBtn: function() {
            var self = this;

            // Status Btn
            $('.btn-check').on('click', function(ev){
                var $this   = $(this);
                var href    = $this.attr('href');
                var display = $this.parents('tr').find('.stat-display');
                
                $this.find('.fa-spin').removeClass('hide');

                $.ajax({
                    url: href,
                    context: document.body
                }).done(function(data) {
                    $this.parents('tr').find('.state-display').empty().append(data['html']);
                    $this.find('.fa-spin').addClass('hide');
                });                         

                return ev.preventDefault();
            });

            $('.state-display').on('click' ,function(){
                self.addTerm( $(this).find('.stat-result-text').text() );
            });

            // Deploy Btn
            $('.confirm-deploy').on('click', function(ev){
                var $this   = $(this);
                var href    = $this.attr('href');
                var display = $this.parents('tr').find('.stat-display');

                swal({
                  title: "Are you sure ?",
                  text: "This will deploy your application",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Yes, deploy it!",
                  closeOnConfirm: true
                },
                function(){
                    
                    $this.find('.fa-spin').removeClass('hide');

                    $.ajax({
                        url: href,
                        context: document.body
                    }).done(function(data) {
                        $this.find('.fa-spin').addClass('hide');
                        
                        self.addTerm( data );
                    }); 
                });

                return ev.preventDefault();
            });

            // Delete Record
            $('.confirm-delete').on('click', function(ev){
                var href = $(this).attr('href');

                swal({
                  title: "Are you sure ?",
                  text: "This recording will be permanently deleted",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url: href,
                        method: "POST"
                    }).done(function(data) {
                        swal({
                          title: "Deleted !",
                          text: "This record has been deleted",
                          type: "success",
                          confirmButtonText: "Ok!",
                          closeOnConfirm: true
                        },
                        function(){
                            location.reload();
                        });
                    })
                    .error(function(data) {
                        swal("Oops", "We couldn't connect to the server!", "error");
                    });
                });

                return ev.preventDefault();
            });
        },
        initDatatable: function() {
            $('#listing').dataTable();
        },
    };

    $(document).ready(function() {
        UI.init();
    });
    

})(jQuery);