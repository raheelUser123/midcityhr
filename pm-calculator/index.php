<?php $title='Property Management Turna Calculator | Mid City Home Restoration';$description='Estimate turna work, vacancy cost, and portfolio impact.';require_once __DIR__.'/../includes/header.php';?><style>
#mhr-pm-page,
*,
*::before,
*::after{
  box-sizing:border-box;
}

#mhr-pm-page{
  --mhr-navy:#0d1f2b;
  --mhr-navy-mid:#1A3B5D;
  --mhr-blue:#2563EB;
  --mhr-gold:#C8A45E;
  --mhr-gold-light:#d9bc7e;
  --mhr-brown:#B8845A;
  --mhr-cream:#F8F6F3;
  --mhr-white:#fff;
  --mhr-text:#1A1A2E;
  --mhr-muted:#64748B;
  --mhr-border:#E2D9CE;
  --mhr-max:1180px;
  --mhr-navh:76px;
  --mhr-sans:Arial,Helvetica,sans-serif;
  --mhr-serif:Georgia,serif;

  width:100%;
  margin:0;
  padding:0;
  background:#fff;
  color:var(--mhr-text);
  font-family:var(--mhr-sans);
  line-height:1.6;
  overflow-x:hidden;
}

a{
  text-decoration:none;
}

.mhr-container{
  width:100%;
  max-width:var(--mhr-max);
  margin:0 auto;
  padding:0 24px;
}

/* HEADER */
.mhr-progress{
  position:fixed;
  top:0;
  left:0;
  width:0;
  height:2px;
  background:var(--mhr-gold);
  z-index:100002;
}

.mhr-header{
  position:fixed;
  top:0;
  left:0;
  right:0;
  height:var(--mhr-navh);
  z-index:100001;
  background:rgba(245,241,234,.97);
  backdrop-filter:blur(14px);
  -webkit-backdrop-filter:blur(14px);
  border-bottom:1px solid rgba(0,0,0,.07);
  transition:box-shadow .25s ease;
}

.mhr-header-inner{
  max-width:var(--mhr-max);
  height:100%;
  margin:0 auto;
  padding:0 24px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:22px;
}

.mhr-logo{
  display:flex;
  align-items:center;
  flex:0 0 auto;
}

.mhr-logo img{
  height:42px;
  width:auto;
  max-width:190px;
  display:block;
}

.mhr-nav{
  display:flex;
  align-items:center;
  justify-content:center;
  gap:19px;
  flex:1 1 auto;
}

.mhr-nav a{
  color:#4a4a4a;
  font-size:13px;
  font-weight:700;
  letter-spacing:.055em;
  text-transform:uppercase;
  white-space:nowrap;
  line-height:1;
}

.mhr-nav a:hover{
  color:var(--mhr-navy);
}

.mhr-header-actions{
  display:flex;
  align-items:center;
  gap:13px;
  flex:0 0 auto;
}

.mhr-phone{
  color:var(--mhr-navy);
  font-size:13.5px;
  font-weight:800;
  white-space:nowrap;
}

.mhr-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-height:42px;
  padding:11px 19px;
  border-radius:7px;
  border:0;
  font-family:var(--mhr-sans);
  font-size:14px;
  font-weight:800;
  line-height:1;
  cursor:pointer;
  transition:.2s ease;
}

.mhr-btn-gold{
  background:var(--mhr-gold);
  color:#fff!important;
}

.mhr-btn-gold:hover{
  background:var(--mhr-gold-light);
}

.mhr-menu-btn{
  display:none;
  width:38px;
  height:38px;
  background:transparent;
  border:0;
  cursor:pointer;
  padding:0;
}

.mhr-menu-btn span{
  display:block;
  width:24px;
  height:2px;
  margin:5px auto;
  background:var(--mhr-navy);
}

.mhr-mobile-drawer{
  position:fixed;
  inset:0;
  z-index:100003;
  background:var(--mhr-navy);
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:18px;
  opacity:0;
  pointer-events:none;
  transition:opacity .25s ease;
}

.mhr-mobile-drawer.is-open{
  opacity:1;
  pointer-events:auto;
}

.mhr-mobile-drawer a{
  color:#fff;
  font-family:var(--mhr-serif);
  font-size:30px;
  line-height:1.2;
}

.mhr-mobile-drawer .mhr-btn{
  font-family:var(--mhr-sans);
  font-size:15px;
}

.mhr-close{
  position:absolute;
  top:22px;
  right:28px;
  background:transparent;
  border:0;
  color:#fff;
  font-size:40px;
  line-height:1;
  cursor:pointer;
}

/* HERO */
.pmcalc-hero{
  background:linear-gradient(135deg,var(--mhr-cream),#fff);
  border-bottom:1px solid var(--mhr-border);
  padding:calc(var(--mhr-navh) + 72px) 24px 58px;
  text-align:center;
}

.pmcalc-kicker{
  color:var(--mhr-gold);
  font-size:12px;
  font-weight:900;
  letter-spacing:.12em;
  text-transform:uppercase;
  margin-bottom:12px;
}

.pmcalc-hero h1{
  font-family:var(--mhr-serif);
  font-size:clamp(2.05rem,4.5vw,3.35rem);
  font-weight:700;
  color:var(--mhr-navy-mid);
  margin:0 0 16px;
  line-height:1.12;
}

.pmcalc-hero p{
  font-size:1.08rem;
  color:var(--mhr-muted);
  max-width:680px;
  margin:0 auto;
  line-height:1.7;
}

/* CALCULATOR WRAP */
.pmcalc-main{
  background:#fff;
  padding:48px 0 32px;
}

.pmcalc-embed-wrap{
  max-width:900px;
  margin:0 auto;
}

/* CALCULATOR APP */
#pm-calculator-app{
  display:block;
  text-align:left;
  padding:0;
  font-family:var(--mhr-sans);
  color:var(--mhr-text);
  background:var(--mhr-cream);
  border:1px solid var(--mhr-border);
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 10px 34px rgba(13,31,43,.06);
}

#pm-calculator-app .pmc-header{
  background:var(--mhr-navy-mid);
  padding:30px 30px 25px;
  color:#fff;
}

#pm-calculator-app .pmc-header h3{
  font-family:var(--mhr-serif);
  font-size:1.45rem;
  font-weight:700;
  margin:0 0 7px;
  color:#fff;
  line-height:1.3;
}

#pm-calculator-app .pmc-header p{
  font-size:.92rem;
  color:#CBD5E1;
  margin:0;
  line-height:1.55;
}

#pm-calculator-app .pmc-body{
  padding:30px;
}

#pm-calculator-app .pmc-row{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:16px;
  margin-bottom:16px;
}

#pm-calculator-app .pmc-field{
  display:flex;
  flex-direction:column;
  gap:6px;
}

#pm-calculator-app label{
  font-size:.82rem;
  font-weight:800;
  color:var(--mhr-muted);
  letter-spacing:.02em;
}

#pm-calculator-app select,
#pm-calculator-app input[type="number"]{
  width:100%;
  min-height:44px;
  padding:11px 12px;
  border:1px solid var(--mhr-border);
  border-radius:8px;
  font-family:var(--mhr-sans);
  font-size:.96rem;
  color:var(--mhr-text);
  background:#fff;
  outline:none;
}

#pm-calculator-app select:focus,
#pm-calculator-app input[type="number"]:focus{
  border-color:var(--mhr-blue);
  box-shadow:0 0 0 3px rgba(37,99,235,.12);
}

#pm-calculator-app .pmc-scope-heading{
  font-size:.82rem;
  font-weight:800;
  color:var(--mhr-muted);
  letter-spacing:.02em;
  margin:10px 0 12px;
}

#pm-calculator-app .pmc-checks{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:8px 16px;
  margin-bottom:22px;
}

#pm-calculator-app .pmc-check{
  display:flex;
  align-items:flex-start;
  gap:9px;
  cursor:pointer;
  font-size:.89rem;
  color:var(--mhr-text);
  line-height:1.4;
  padding:8px 9px;
  border-radius:8px;
  transition:background .12s;
}

#pm-calculator-app .pmc-check:hover{
  background:rgba(37,99,235,.04);
}

#pm-calculator-app .pmc-check input[type="checkbox"]{
  margin-top:2px;
  accent-color:var(--mhr-blue);
  width:16px;
  height:16px;
  flex-shrink:0;
}

#pm-calculator-app .pmc-check-label{
  display:flex;
  flex-direction:column;
}

#pm-calculator-app .pmc-check-range{
  font-size:.75rem;
  color:var(--mhr-muted);
}

#pm-calculator-app .pmc-licensed{
  font-size:.69rem;
  color:var(--mhr-blue);
  font-weight:900;
  letter-spacing:.03em;
}

#pm-calculator-app .pmc-btn{
  display:block;
  width:100%;
  min-height:52px;
  padding:14px;
  border:0;
  border-radius:8px;
  background:var(--mhr-blue);
  color:#fff;
  font-family:var(--mhr-sans);
  font-size:1rem;
  font-weight:800;
  cursor:pointer;
  transition:.15s;
}

#pm-calculator-app .pmc-btn:hover{
  background:#1D4ED8;
  transform:translateY(-1px);
}

#pm-calculator-app .pmc-results{
  display:none;
  margin-top:26px;
  border-top:2px solid var(--mhr-border);
  padding-top:24px;
}

#pm-calculator-app .pmc-results.visible{
  display:block;
}

#pm-calculator-app .pmc-results-title{
  font-family:var(--mhr-serif);
  font-size:1.25rem;
  font-weight:700;
  color:var(--mhr-navy-mid);
  margin:0 0 16px;
}

#pm-calculator-app .pmc-summary-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px;
  margin-bottom:20px;
}

#pm-calculator-app .pmc-summary-card{
  background:#fff;
  border:1px solid var(--mhr-border);
  border-radius:9px;
  padding:16px;
}

#pm-calculator-app .pmc-summary-card.highlight{
  border-color:var(--mhr-brown);
  border-width:2px;
  background:#FDF8F3;
}

#pm-calculator-app .pmc-card-label{
  font-size:.75rem;
  font-weight:800;
  color:var(--mhr-muted);
  text-transform:uppercase;
  letter-spacing:.05em;
  margin:0 0 6px;
}

#pm-calculator-app .pmc-card-value{
  font-family:var(--mhr-serif);
  font-size:1.3rem;
  font-weight:700;
  color:var(--mhr-navy-mid);
  margin:0;
  line-height:1.3;
}

#pm-calculator-app .pmc-card-sub{
  font-size:.75rem;
  color:var(--mhr-muted);
  margin:4px 0 0;
}

#pm-calculator-app .pmc-breakdown{
  margin:20px 0;
}

#pm-calculator-app .pmc-breakdown-title{
  font-size:.82rem;
  font-weight:800;
  color:var(--mhr-muted);
  margin:0 0 10px;
  text-transform:uppercase;
  letter-spacing:.04em;
}

#pm-calculator-app .pmc-breakdown-table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border-radius:8px;
  overflow:hidden;
}

#pm-calculator-app .pmc-breakdown-table th{
  font-size:.75rem;
  font-weight:800;
  color:var(--mhr-muted);
  text-align:left;
  padding:9px 10px;
  border-bottom:2px solid var(--mhr-border);
  text-transform:uppercase;
  letter-spacing:.04em;
}

#pm-calculator-app .pmc-breakdown-table td{
  font-size:.88rem;
  color:var(--mhr-text);
  padding:9px 10px;
  border-bottom:1px solid var(--mhr-border);
}

#pm-calculator-app .pmc-breakdown-table tr:last-child td{
  border-bottom:0;
}

#pm-calculator-app .pmc-row-total td{
  font-weight:900;
  border-top:2px solid var(--mhr-navy-mid);
  padding-top:12px;
}

#pm-calculator-app .pmc-licensed-note{
  background:#EFF6FF;
  border:1px solid #BFDBFE;
  border-radius:9px;
  padding:14px 16px;
  margin:16px 0;
}

#pm-calculator-app .pmc-licensed-note p{
  font-size:.82rem;
  color:#1E40AF;
  margin:0;
  line-height:1.55;
}

#pm-calculator-app .pmc-licensed-note strong{
  color:var(--mhr-navy-mid);
}

#pm-calculator-app .pmc-vacancy-section{
  background:#fff;
  border:1px solid var(--mhr-border);
  border-radius:9px;
  padding:16px;
  margin:16px 0;
}

#pm-calculator-app .pmc-vacancy-section h4{
  font-family:var(--mhr-serif);
  font-size:1rem;
  font-weight:700;
  color:var(--mhr-navy-mid);
  margin:0 0 8px;
}

#pm-calculator-app .pmc-vacancy-row{
  display:flex;
  justify-content:space-between;
  gap:16px;
  font-size:.88rem;
  padding:5px 0;
  color:var(--mhr-text);
}

#pm-calculator-app .pmc-vacancy-row.total{
  font-weight:900;
  border-top:1px solid var(--mhr-border);
  margin-top:8px;
  padding-top:10px;
}

#pm-calculator-app .pmc-cta-box{
  background:var(--mhr-navy-mid);
  border-radius:11px;
  padding:28px;
  text-align:center;
  margin:24px 0 16px;
}

#pm-calculator-app .pmc-cta-box p{
  font-size:.95rem;
  color:#CBD5E1;
  margin:0 0 16px;
  line-height:1.6;
}

#pm-calculator-app .pmc-cta-btn{
  display:inline-block;
  background:var(--mhr-brown);
  color:#fff;
  font-family:var(--mhr-sans);
  font-size:1rem;
  font-weight:800;
  padding:14px 32px;
  border-radius:8px;
  text-decoration:none;
  transition:.15s;
}

#pm-calculator-app .pmc-cta-btn:hover{
  background:#a0724a;
  transform:translateY(-2px);
  color:#fff;
}

#pm-calculator-app .pmc-cta-phone{
  font-size:.88rem;
  color:#94A3B8;
  margin:12px 0 0;
}

#pm-calculator-app .pmc-cta-phone a{
  color:var(--mhr-brown);
  font-weight:800;
}

#pm-calculator-app .pmc-disclaimer-box{
  font-size:.8rem;
  color:var(--mhr-muted);
  line-height:1.6;
  border-left:3px solid var(--mhr-border);
  padding-left:14px;
  margin:0;
}

#pm-calculator-app .pmc-disclaimer-box p{
  margin:0 0 6px;
}

#pm-calculator-app .pmc-disclaimer-box p:last-child{
  margin:0;
}

/* HOW TO USE */
.pmcalc-how{
  max-width:900px;
  margin:42px auto 56px;
}

.pmcalc-how h2{
  font-family:var(--mhr-serif);
  font-size:1.65rem;
  font-weight:700;
  color:var(--mhr-navy-mid);
  margin:0 0 24px;
}

.pmcalc-steps{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:20px;
  list-style:none;
  margin:0;
  padding:0;
}

.pmcalc-steps li{
  border:1px solid var(--mhr-border);
  border-radius:11px;
  padding:24px 20px;
  background:var(--mhr-cream);
}

.pmcalc-step-number{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  width:34px;
  height:34px;
  border-radius:50%;
  background:var(--mhr-navy-mid);
  color:#fff;
  font-size:.88rem;
  font-weight:900;
  margin-bottom:12px;
}

.pmcalc-step-text{
  font-size:.95rem;
  color:var(--mhr-muted);
  line-height:1.6;
  margin:0;
}

/* LINKS */
.pmcalc-links{
  max-width:900px;
  margin:0 auto 48px;
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}

.pmcalc-links-label{
  font-size:.88rem;
  font-weight:800;
  color:var(--mhr-muted);
  white-space:nowrap;
}

.pmcalc-link{
  font-size:.88rem;
  font-weight:700;
  color:var(--mhr-blue);
  padding:7px 15px;
  border:1px solid rgba(37,99,235,.25);
  border-radius:100px;
  transition:.15s;
  white-space:nowrap;
}

.pmcalc-link:hover{
  background:rgba(37,99,235,.07);
}

/* CTA */
.pmcalc-cta{
  background:var(--mhr-navy-mid);
  padding:60px 24px;
  text-align:center;
}

.pmcalc-cta-eyebrow{
  font-size:.82rem;
  font-weight:800;
  letter-spacing:.1em;
  text-transform:uppercase;
  color:var(--mhr-brown);
  margin-bottom:10px;
}

.pmcalc-cta h2{
  font-family:var(--mhr-serif);
  font-size:clamp(1.55rem,3.5vw,2.15rem);
  font-weight:700;
  color:#fff;
  margin:0 0 8px;
  line-height:1.25;
}

.pmcalc-cta p{
  font-size:.95rem;
  color:rgba(255,255,255,.66);
  margin:0 0 28px;
}

.pmcalc-cta-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-height:52px;
  padding:16px 36px;
  border-radius:8px;
  background:var(--mhr-brown);
  color:#fff;
  font-size:1rem;
  font-weight:800;
  transition:.15s;
}

.pmcalc-cta-btn:hover{
  background:#a0724a;
  transform:translateY(-2px);
}

/* DISCLAIMER */
.pmcalc-disclaimer{
  max-width:900px;
  margin:34px auto 54px;
  border-left:3px solid var(--mhr-border);
  padding-left:20px;
}

.pmcalc-disclaimer p{
  font-size:.88rem;
  color:var(--mhr-muted);
  line-height:1.65;
  margin:0;
}

.pmcalc-disclaimer p + p{
  margin-top:12px;
}

/* FOOTER */
.mhr-footer{
  background:var(--mhr-navy);
  color:rgba(255,255,255,.62);
  padding:56px 0 32px;
  border-top:1px solid rgba(255,255,255,.07);
}

.mhr-footer-grid{
  display:grid;
  grid-template-columns:2fr 1fr 1fr 1fr;
  gap:40px;
  margin-bottom:38px;
}

.mhr-footer h4{
  color:var(--mhr-gold);
  font-size:14px;
  font-weight:900;
  letter-spacing:.1em;
  text-transform:uppercase;
  margin:0 0 16px;
}

.mhr-footer p,
.mhr-footer a,
.mhr-footer li{
  color:rgba(255,255,255,.62);
  font-size:15px;
  line-height:1.7;
}

.mhr-footer a:hover{
  color:var(--mhr-gold);
}

.mhr-footer ul{
  list-style:none;
  padding:0;
  margin:0;
}

.mhr-footer li{
  margin-bottom:8px;
}

.mhr-footer-bottom{
  border-top:1px solid rgba(255,255,255,.08);
  padding-top:22px;
}

.mhr-footer-bottom p{
  color:rgba(255,255,255,.4);
  font-size:13px;
  margin:0 0 8px;
}

.mhr-sticky{
  display:none;
  position:fixed;
  left:0;
  right:0;
  bottom:0;
  z-index:100000;
  background:#fff;
  border-top:1px solid var(--mhr-border);
  box-shadow:0 -4px 20px rgba(0,0,0,.08);
  padding:12px 16px;
}

.mhr-sticky a{
  display:flex;
  width:100%;
  min-height:48px;
  align-items:center;
  justify-content:center;
  border-radius:8px;
  background:var(--mhr-gold);
  color:#fff;
  font-weight:900;
}

/* RESPONSIVE */
@media(max-width:1100px){
  .mhr-nav,
  .mhr-header-actions{
    display:none;
  }

  .mhr-menu-btn{
    display:block;
  }

  .mhr-footer-grid{
    grid-template-columns:1fr 1fr;
  }
}

@media(max-width:768px){
  #mhr-pm-page{
    --mhr-navh:64px;
    padding-bottom:72px;
  }

  .mhr-logo img{
    height:38px;
  }

  .mhr-header-inner,
  .mhr-container{
    padding-left:18px;
    padding-right:18px;
  }

  .pmcalc-hero{
    padding:calc(var(--mhr-navh) + 46px) 18px 46px;
  }

  .pmcalc-main{
    padding-top:36px;
  }

  #pm-calculator-app .pmc-row,
  #pm-calculator-app .pmc-checks,
  #pm-calculator-app .pmc-summary-grid,
  .pmcalc-steps,
  .mhr-footer-grid{
    grid-template-columns:1fr;
  }

  #pm-calculator-app .pmc-body{
    padding:20px 16px;
  }

  #pm-calculator-app .pmc-header{
    padding:24px 16px 20px;
  }

  #pm-calculator-app .pmc-cta-box{
    padding:24px 16px;
  }

  .pmcalc-links{
    align-items:flex-start;
  }

  .mhr-sticky{
    display:block;
  }
}
</style><div id='mhr-pm-page'>
  <section class="pmcalc-hero">
    <div class="mhr-container">
      <div class="pmcalc-kicker">Property Manager Tool</div>
      <h1>Property Management Turna Calculator</h1>
      <p>Estimate turna costs before the site visit. Select unit details, scope of work, and get a ballpark range in 60 seconds.</p>
    </div>
  </section>

  <!-- CALCULATOR -->
  <main class="pmcalc-main">
    <div class="mhr-container">
      <div class="pmcalc-embed-wrap">
        <div id="pm-calculator-app">
          <div class="pmc-header">
            <h3>PM Turna Cost Calculator</h3>
            <p>Estimate turna costs for your rental portfolio. Select unit details, check scope items, and get a ballpark range.</p>
          </div>

          <div id="pmcBody" class="pmc-body">
            <div class="pmc-row">
              <div class="pmc-field">
                <label for="pmcUnits">Number of Units</label>
                <input id="pmcUnits" max="50" min="1" type="number" value="1">
              </div>

              <div class="pmc-field">
                <label for="pmcType">Unit Type</label>
                <select id="pmcType">
                  <option value="studio">Studio</option>
                  <option value="1br">1 Bedroom</option>
                  <option selected value="2br">2 Bedroom</option>
                  <option value="3br">3 Bedroom</option>
                  <option value="4br">4 Bedroom+</option>
                </select>
              </div>
            </div>

            <div class="pmc-row">
              <div class="pmc-field">
                <label for="pmcSqft">Avg. Unit Size (sq ft)</label>
                <input id="pmcSqft" max="5000" min="200" type="number" value="900">
              </div>

              <div class="pmc-field">
                <label for="pmcCondition">Condition at Turna</label>
                <select id="pmcCondition">
                  <option value="good">Good - Normal Wear</option>
                  <option selected value="fair">Fair - Moderate Wear</option>
                  <option value="poor">Poor - Heavy Damage</option>
                </select>
              </div>
            </div>

            <div class="pmc-row">
              <div class="pmc-field">
                <label for="pmcRent">Monthly Rent per Unit ($)</label>
                <input id="pmcRent" max="10000" min="0" type="number" value="1200" placeholder="For vacancy cost calc">
              </div>

              <div class="pmc-field"></div>
            </div>

            <div class="pmc-scope-heading">Scope of Work (check all that apply)</div>
            <div id="pmcChecks" class="pmc-checks"></div>

            <button id="pmcCalcBtn" class="pmc-btn" type="button">Calculate Turna Estimate</button>

            <div id="pmcResults" class="pmc-results"></div>
          </div>
        </div>
      </div>

      <!-- HOW TO USE -->
      <section class="pmcalc-how">
        <h2>How to Use This Calculator</h2>
        <ol class="pmcalc-steps">
          <li>
            <div class="pmcalc-step-number">1</div>
            <p class="pmcalc-step-text">Select your property type and unit count.</p>
          </li>

          <li>
            <div class="pmcalc-step-number">2</div>
            <p class="pmcalc-step-text">Choose the scope of work needed for each unit.</p>
          </li>

          <li>
            <div class="pmcalc-step-number">3</div>
            <p class="pmcalc-step-text">Review your estimated range. Final pricing is determined after on-site assessment.</p>
          </li>
        </ol>
      </section>

      <!-- LINKS -->
      <div class="pmcalc-links">
        <span class="pmcalc-links-label">Also useful:</span>
        <a class="pmcalc-link" href="/estimate/">Full Scope Simulator →</a>
        <a class="pmcalc-link" href="/services/property-management-turnas/">PM Turna Service →</a>
        <a class="pmcalc-link" href="/investment-analysis/">Investment Analysis Tool →</a>
      </div>
    </div>
  </main>

  <!-- CTA -->
  <section class="pmcalc-cta">
    <div class="mhr-container">
      <div class="pmcalc-cta-eyebrow">Ready for exact numbers?</div>
      <h2>Get an exact quote for your property</h2>
      <p>We'll walk the units, assess scope, and give you firm pricing — no surprises.</p>
      <a class="pmcalc-cta-btn" href="/contact/">Book Your Free Site Visit</a>
    </div>
  </section>

  <!-- DISCLAIMER -->
  <section class="pmcalc-disclaimer">
    <p><strong>Note:</strong> Estimates are approximate ranges only. Final pricing is determined after an on-site assessment by the Mid City Home Restoration team. Actual costs may vary based on unit condition, material selections, and local code requirements.</p>
    <p>Serving property managers across Western New York within a 45-mile radius of Lockport, NY. Licensed NY Electrician and Plumber subcontracted per code where required.</p>
  </section>

  </div><script>
(function(){
  var SCOPE_ITEMS = [
    {id:"paint",name:"Paint (Interior Walls + Trim)",low:800,high:1800,days:2,licensed:false},
    {id:"flooring",name:"Flooring (LVP / Tile Replacement)",low:1200,high:3500,days:3,licensed:false},
    {id:"kitchen",name:"Kitchen Refresh (Cabinets, Counters, Hardware)",low:2000,high:5000,days:4,licensed:false},
    {id:"bathroom",name:"Bathroom Refresh (Vanity, Fixtures, Tile Repair)",low:1500,high:3500,days:3,licensed:false},
    {id:"cleaning",name:"Deep Cleaning",low:200,high:500,days:1,licensed:false},
    {id:"appliance",name:"Appliance Replacement",low:1500,high:4000,days:1,licensed:false},
    {id:"electrical",name:"Electrical (Outlets, Switches, Fixtures)",low:300,high:1200,days:1,licensed:true},
    {id:"plumbing",name:"Plumbing (Faucets, Supply Lines, Drains)",low:400,high:1500,days:1,licensed:true},
    {id:"drywall",name:"Drywall Patching / Repair",low:200,high:800,days:1,licensed:false},
    {id:"punchlist",name:"General Punch List Items",low:300,high:1000,days:1,licensed:false}
  ];

  var SIZE_MULT = {studio:0.6,"1br":0.8,"2br":1.0,"3br":1.2,"4br":1.4};
  var COND_MULT = {good:0.7,fair:1.0,poor:1.3};
  var DEFAULT_SQFT = {studio:450,"1br":650,"2br":900,"3br":1200,"4br":1600};

  function $(id){ return document.getElementById(id); }

  function fmt(n){
    return "$" + Math.round(n).toLocaleString();
  }

  function calcTimeline(items, condMult){
    var base = 0;
    items.forEach(function(it){ base += it.days; });
    var parallel = Math.max(Math.ceil(base * 0.6), 1);
    return Math.max(Math.ceil(parallel * condMult), 1);
  }

  var checksEl = $("pmcChecks");
  if(checksEl){
    SCOPE_ITEMS.forEach(function(item){
      var label = document.createElement("label");
      label.className = "pmc-check";

      var checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.value = item.id;
      checkbox.id = "pmc_" + item.id;

      var span = document.createElement("span");
      span.className = "pmc-check-label";

      var name = document.createElement("span");
      name.textContent = item.name;

      var range = document.createElement("span");
      range.className = "pmc-check-range";
      range.textContent = fmt(item.low) + " - " + fmt(item.high) + " per unit (base)";

      span.appendChild(name);
      span.appendChild(range);

      if(item.licensed){
        var lic = document.createElement("span");
        lic.className = "pmc-licensed";
        lic.textContent = "LICENSED TRADE REQUIRED";
        span.appendChild(lic);
      }

      label.appendChild(checkbox);
      label.appendChild(span);
      checksEl.appendChild(label);
    });
  }

  var typeEl = $("pmcType");
  var sqftEl = $("pmcSqft");

  if(typeEl && sqftEl){
    typeEl.addEventListener("change", function(){
      sqftEl.value = DEFAULT_SQFT[typeEl.value] || 900;
    });
  }

  var calcBtn = $("pmcCalcBtn");

  if(calcBtn){
    calcBtn.addEventListener("click", function(){
      var units = parseInt($("pmcUnits").value, 10) || 1;
      units = Math.max(1, Math.min(50, units));

      var unitType = typeEl.value;
      var sqft = parseInt(sqftEl.value, 10) || DEFAULT_SQFT[unitType];
      var condition = $("pmcCondition").value;
      var rent = parseFloat($("pmcRent").value) || 0;

      var sizeMult = SIZE_MULT[unitType] || 1;
      var condMult = COND_MULT[condition] || 1;
      var baseSqft = DEFAULT_SQFT[unitType] || 900;
      var sqftAdj = 0.5 + (sqft / baseSqft) * 0.5;
      sqftAdj = Math.max(0.5, Math.min(2.0, sqftAdj));

      var selected = [];
      var totalLow = 0;
      var totalHigh = 0;
      var licensedItems = [];

      SCOPE_ITEMS.forEach(function(item){
        var cb = $("pmc_" + item.id);

        if(cb && cb.checked){
          var adjLow = Math.round(item.low * sizeMult * condMult * sqftAdj);
          var adjHigh = Math.round(item.high * sizeMult * condMult * sqftAdj);

          selected.push({
            name:item.name,
            low:adjLow,
            high:adjHigh,
            days:item.days,
            licensed:item.licensed
          });

          totalLow += adjLow;
          totalHigh += adjHigh;

          if(item.licensed){
            licensedItems.push(item.name);
          }
        }
      });

      var results = $("pmcResults");

      if(selected.length === 0){
        results.className = "pmc-results visible";
        results.innerHTML = '<p style="color:#64748B;text-align:center;padding:16px;">Select at least one scope item above to see your estimate.</p>';
        return;
      }

      var timeline = calcTimeline(selected, condMult);
      var dailyRent = rent / 30;
      var vacancyCostPerUnit = Math.round(dailyRent * timeline);
      var totalVacancy = vacancyCostPerUnit * units;
      var netLow = totalLow * units + totalVacancy;
      var netHigh = totalHigh * units + totalVacancy;

      var breakdownRows = selected.map(function(item){
        return '<tr><td>' + item.name + (item.licensed ? ' *' : '') + '</td><td>' + fmt(item.low) + ' - ' + fmt(item.high) + '</td></tr>';
      }).join("");

      breakdownRows += '<tr class="pmc-row-total"><td>Per-Unit Total</td><td>' + fmt(totalLow) + ' - ' + fmt(totalHigh) + '</td></tr>';

      var licensedHtml = "";
      if(licensedItems.length){
        licensedHtml =
          '<div class="pmc-licensed-note">' +
            '<p><strong>Licensed Trades Required:</strong> ' + licensedItems.join(", ") + '. All electrical and plumbing work must be performed by a licensed NY professional per code. MHR coordinates licensed subcontractors on your behalf.</p>' +
          '</div>';
      }

      var vacancyHtml = "";
      if(rent > 0){
        vacancyHtml =
          '<div class="pmc-vacancy-section">' +
            '<h4>Vacancy Cost Impact</h4>' +
            '<div class="pmc-vacancy-row"><span>Daily vacancy cost</span><span>' + fmt(dailyRent) + ' / day</span></div>' +
            '<div class="pmc-vacancy-row"><span>Est. turna time</span><span>' + timeline + ' day' + (timeline !== 1 ? 's' : '') + ' per unit</span></div>' +
            '<div class="pmc-vacancy-row"><span>Vacancy cost per unit</span><span>' + fmt(vacancyCostPerUnit) + '</span></div>' +
            (units > 1 ? '<div class="pmc-vacancy-row"><span>Total vacancy cost (' + units + ' units)</span><span>' + fmt(totalVacancy) + '</span></div>' : '') +
            '<div class="pmc-vacancy-row total"><span>Net turna cost (work + vacancy)</span><span>' + fmt(netLow) + ' - ' + fmt(netHigh) + '</span></div>' +
          '</div>';
      }

      var volumeNote = units >= 5 ? '<p class="pmc-card-sub">Multi-unit portfolio — volume pricing may apply at site visit.</p>' : '';

      var html =
        '<h4 class="pmc-results-title">Your Turna Estimate</h4>' +
        '<div class="pmc-summary-grid">' +
          '<div class="pmc-summary-card">' +
            '<div class="pmc-card-label">Per Unit</div>' +
            '<div class="pmc-card-value">' + fmt(totalLow) + ' - ' + fmt(totalHigh) + '</div>' +
            '<p class="pmc-card-sub">' + selected.length + ' scope item' + (selected.length !== 1 ? 's' : '') + ' selected.</p>' +
          '</div>' +
          '<div class="pmc-summary-card ' + (units > 1 ? 'highlight' : '') + '">' +
            '<div class="pmc-card-label">Total Portfolio (' + units + ' unit' + (units !== 1 ? 's' : '') + ')</div>' +
            '<div class="pmc-card-value">' + fmt(totalLow * units) + ' - ' + fmt(totalHigh * units) + '</div>' +
            volumeNote +
          '</div>' +
          '<div class="pmc-summary-card">' +
            '<div class="pmc-card-label">Est. Timeline / Unit</div>' +
            '<div class="pmc-card-value">' + timeline + ' Day' + (timeline !== 1 ? 's' : '') + '</div>' +
            '<p class="pmc-card-sub">Concurrent scheduling may reduce total portfolio time.</p>' +
          '</div>' +
          (rent > 0 ? '<div class="pmc-summary-card highlight"><div class="pmc-card-label">Net Cost (Work + Vacancy)</div><div class="pmc-card-value">' + fmt(netLow) + ' - ' + fmt(netHigh) + '</div><p class="pmc-card-sub">Includes ' + fmt(totalVacancy) + ' in estimated vacancy loss.</p></div>' : '') +
        '</div>' +
        '<div class="pmc-breakdown">' +
          '<div class="pmc-breakdown-title">Per-Unit Cost Breakdown</div>' +
          '<table class="pmc-breakdown-table">' +
            '<thead><tr><th>Scope Item</th><th>Estimated Range</th></tr></thead>' +
            '<tbody>' + breakdownRows + '</tbody>' +
          '</table>' +
        '</div>' +
        licensedHtml +
        vacancyHtml +
        '<div class="pmc-cta-box">' +
          '<p>Ready for an exact quote for your portfolio?</p>' +
          '<a href="/contact/" class="pmc-cta-btn">Book Your Free Site Visit</a>' +
          '<div class="pmc-cta-phone">Or call <a href="tel:+18337366647">1-833-RENO-MHR</a></div>' +
        '</div>' +
        '<div class="pmc-disclaimer-box">' +
          '<p>Estimates are based on typical Western NY market rates. Final pricing determined after on-site assessment. Licensed NY electrician and plumber required for electrical and plumbing work — subcontracted per code.</p>' +
          '<p>Serving Western New York within a 45-mile radius of Lockport, NY.</p>' +
        '</div>';

      results.className = "pmc-results visible";
      results.innerHTML = html;

      setTimeout(function(){
        results.scrollIntoView({behavior:"smooth", block:"start"});
      }, 80);
    });
  }

  var header = document.getElementById("mhrPmHeader");
  var progress = document.getElementById("mhrPmProgress");
  var openBtn = document.getElementById("mhrPmMenuOpen");
  var closeBtn = document.getElementById("mhrPmMenuClose");
  var drawer = document.getElementById("mhrPmDrawer");

  if(openBtn && drawer){
    openBtn.addEventListener("click", function(){
      drawer.classList.add("is-open");
    });
  }

  if(closeBtn && drawer){
    closeBtn.addEventListener("click", function(){
      drawer.classList.remove("is-open");
    });
  }

  if(drawer){
    drawer.querySelectorAll("a").forEach(function(link){
      link.addEventListener("click", function(){
        drawer.classList.remove("is-open");
      });
    });
  }

  window.addEventListener("scroll", function(){
    var max = document.documentElement.scrollHeight - window.innerHeight;
    var pct = max > 0 ? (window.scrollY / max) * 100 : 0;

    if(progress){
      progress.style.width = pct + "%";
    }

    if(header){
      header.style.boxShadow = window.scrollY > 20 ? "0 4px 20px rgba(0,0,0,.08)" : "none";
    }
  });
})();
</script><?php require_once __DIR__.'/../includes/footer.php';?>