<div class="modal fade" id="{{$modalId}}">
      <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header bg-primary">
                   <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                   <h4 class="modal-title">{{$tituloModal}}</h4>
               </div>
               <div class="modal-body">
                   {{$slot}}
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-primary center-block" data-dismiss="modal">Fechar</button>
               </div>
           </div>
       </div>
    </div>