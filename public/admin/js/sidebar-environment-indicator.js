document.addEventListener(pimcore.events.pimcoreReady, () => {
    Ext.get("pimcore_navigation").insertHtml(
      "beforeEnd",
      '<h1 style="position: absolute;transform: rotate(-90deg); margin-left: 20px; margin-top: 200px; color: #d7d7d7; transform-origin:0 0">' +
        (pimcore?.settings?.environment || "").toUpperCase() +
      '</h1>'
    );
});
  