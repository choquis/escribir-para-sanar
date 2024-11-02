<!-- Estas notificaciones estan especificamente con if para respuestas desde el backend laravel -->
@if (session('notification-success'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="word-wrap: anywhere">
          {!! session('notification-success') !!}
        </div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

@if (session('notification-info'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-info border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="word-wrap: anywhere">
          {!! session('notification-info') !!}
        </div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

@if (session('notification-warning'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="word-wrap: anywhere">
          {!! session('notification-warning') !!}
        </div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif

@if (session('notification-error'))
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
      aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="word-wrap: anywhere">
          {!! session('notification-danger') !!}
        </div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>
@endif


<!-- Este toast es para llamarlo con js al estilo boostrap -->
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="liveToast" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
    aria-atomic="true" data-bs-autohide="false">
    <div class="d-flex">
      <div id="liveMessage" class="toast-body fs-5" style="word-wrap: anywhere">
        <!-- Mensaje -->
      </div>
      <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"
        aria-label="Close"></button>
    </div>
  </div>
</div>
