(function () {
  const iframe = document.createElement("iframe");
  const body = document.body;
  iframe.id = "form-{iframeId}";
  iframe.src = `{domainUrl}/{formId}?formElementId=form-{iframeId}`;
  iframe.style.width = "100%";
  iframe.style.border = "none";
  const scriptRef = document.getElementById("scriptIframeId-{iframeId}");
  if (scriptRef) {
    scriptRef.parentElement.insertBefore(iframe, scriptRef);
    scriptRef.remove()
  } else {
    document.body.appendChild(iframe);
  }
  window.addEventListener('message', function (event) {
    const iframe = document.getElementById("form-{iframeId}");
    if (iframe && (event.data.formElementId == "form-{iframeId}")) {
      iframe.style.height = `${event.data.clientHeight + 120}px`;
    }
  });
})()
