<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Verificação de Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      
      /*All the styling goes here*/
      
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
      }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; 
      }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; 
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 15px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }

      .btn-primary table td {
        background-color: #3498db; 
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table.body h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table.body p,
        table.body ul,
        table.body ol,
        table.body td,
        table.body span,
        table.body a {
          font-size: 16px !important; 
        }
        table.body .wrapper,
        table.body .article {
          padding: 10px !important; 
        }
        table.body .content {
          padding: 0 !important; 
        }
        table.body .container {
          padding: 0 !important;
          width: 100% !important; 
        }
        table.body .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; 
        }
        table.body .btn table {
          width: 100% !important; 
        }
        table.body .btn a {
          width: 100% !important; 
        }
        table.body .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; 
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; 
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; 
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important; 
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; 
        } 
      }

    </style>
  </head>
  <body>
    <span class="preheader">Verificação de Email</span>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            <table role="presentation" class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td  align="center">
                        <img style="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAYAAADNkKWqAAAAwHpUWHRSYXcgcHJvZmlsZSB0eXBlIGV4aWYAAHjabVDBEcMgDPszRUfAliFmHNLQu27Q8Wti6IW2ukMSOBHGob2ej3DrYJIgadNcco4GKVK4mtHoqCdTlJNPyHS0nodPgU1hCi9odqV5Pn6YStVcugTpfRT2tVDElfUriF3QO+r+GEFlBIG9QCOg+rNiLrpdn7C3uEJ9hU6ia9s/+82mdyS7B8wNhGgMiDeAvhBQzagxI9uHNDyME2aYDeTfnCbCG+LiWRgGCVwrAAABhGlDQ1BJQ0MgcHJvZmlsZQAAeJx9kT1Iw0AcxV9TpUUqDlaU4pChOtlFRRylikWwUNoKrTqYXPoFTRqSFBdHwbXg4Mdi1cHFWVcHV0EQ/ABxdXFSdJES/5cUWsR4cNyPd/ced+8AoVllqtkzB6iaZaQTcTGXXxUDrwgigiEMIywxU09mFrPwHF/38PH1LsazvM/9OfqVgskAn0g8x3TDIt4gntm0dM77xGFWlhTic+IJgy5I/Mh12eU3ziWHBZ4ZNrLpeeIwsVjqYrmLWdlQiaeJo4qqUb6Qc1nhvMVZrdZZ+578haGCtpLhOs1RJLCEJFIQIaOOCqqwEKNVI8VEmvbjHv6I40+RSyZXBYwcC6hBheT4wf/gd7dmcWrSTQrFgd4X2/4YAwK7QKth29/Htt06AfzPwJXW8deawOwn6Y2OFj0CBraBi+uOJu8BlzvAyJMuGZIj+WkKxSLwfkbflAcGb4G+Nbe39j5OH4AsdbV8AxwcAuMlyl73eHewu7d/z7T7+wGwbXK/2v0tfAAADXZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+Cjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IlhNUCBDb3JlIDQuNC4wLUV4aXYyIj4KIDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+CiAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgIHhtbG5zOkdJTVA9Imh0dHA6Ly93d3cuZ2ltcC5vcmcveG1wLyIKICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIgogICB4bXBNTTpEb2N1bWVudElEPSJnaW1wOmRvY2lkOmdpbXA6NWJkMThlN2EtYTgwNS00Y2U5LWJjYTMtZGZjOWU3NjRhMWQ2IgogICB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOmQxNDJmZmIwLTEyZWEtNGI3MC1hM2ViLTJlMDc5NDBjYzdmZSIKICAgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjVmYjRlNjRmLWY3YTItNDBkYi05YmFjLTYxZTBiMWJiYTc2YSIKICAgZGM6Rm9ybWF0PSJpbWFnZS9wbmciCiAgIEdJTVA6QVBJPSIyLjAiCiAgIEdJTVA6UGxhdGZvcm09IldpbmRvd3MiCiAgIEdJTVA6VGltZVN0YW1wPSIxNjkzMDg1MDMxNTQxMDA0IgogICBHSU1QOlZlcnNpb249IjIuMTAuMzQiCiAgIHRpZmY6T3JpZW50YXRpb249IjEiCiAgIHhtcDpDcmVhdG9yVG9vbD0iR0lNUCAyLjEwIgogICB4bXA6TWV0YWRhdGFEYXRlPSIyMDIzOjA4OjI2VDE4OjIzOjUwLTAzOjAwIgogICB4bXA6TW9kaWZ5RGF0ZT0iMjAyMzowODoyNlQxODoyMzo1MC0wMzowMCI+CiAgIDx4bXBNTTpIaXN0b3J5PgogICAgPHJkZjpTZXE+CiAgICAgPHJkZjpsaQogICAgICBzdEV2dDphY3Rpb249InNhdmVkIgogICAgICBzdEV2dDpjaGFuZ2VkPSIvIgogICAgICBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjdiNDg2ZjA0LWFiYzAtNDk0Yy05ZjU3LTE4MDY3NTViOGQ3NyIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iR2ltcCAyLjEwIChXaW5kb3dzKSIKICAgICAgc3RFdnQ6d2hlbj0iMjAyMy0wOC0yNlQxODoyMzo1MSIvPgogICAgPC9yZGY6U2VxPgogICA8L3htcE1NOkhpc3Rvcnk+CiAgPC9yZGY6RGVzY3JpcHRpb24+CiA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgCjw/eHBhY2tldCBlbmQ9InciPz4pv2vKAAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5wgaFRczaP/5uwAAIABJREFUeNrtnXmYHFXV/z+nqichJCEsmZ4ESE8IZHrC5v4qisgiisiiuC8vP1TSw04A2WRRQEBkR5ZMR1433lfBDQVlEUUWURRUQMh0gGRmAsL0JCwJSUimq87vj2pk0lM93ZOZSW73nM/z8Dw63am+deveb51z7rnngmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEYhmEY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" />
                        <p>Este email foi cadastrado em uma conta PDV Acelerado. Para verificar seu email e liberar a conta, clique no link abaixo:</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="center">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td> <a href="<?= $link ?>" target="_blank">Verificar Email</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p>ou cole este link no navegador:</p>
                        <p style="color: #3498db"><?= $link ?></p>
                        <p>Se você não solicitou o cadastro, entre em contado com nossa equipe.</p>
                        <p>Atenciosamente, equipe <strong>PDV <span style="color:#9A031E">ACELERADO</span></strong></p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->

            <!-- START FOOTER -->
            <div class="footer">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" class="content-block powered-by">
                    Powered by <a href="http://sistemasinteligentes.com.br" target="_blank">Sistemas Inteligentes</a>.
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>