<?php 
$title = 'Property Management Turna Calculator | Midcity Handyman & Remodeling';
$description = 'Estimate turna work, vacancy cost, and portfolio impact across Western New York.';
require_once __DIR__.'/../includes/header.php';
?>

<style>
  .process-cards p {
    color: #000;
}
.pmc-results.visible { display: block !important; }
.pmc-summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin: 24px 0; }
.pmc-summary-card { background: var(--cream); border: 1px solid var(--line); border-radius: 12px; padding: 20px; }
.pmc-summary-card.highlight { border-color: var(--gold); border-width: 2px; background: #fffbf3; }
.pmc-card-label { font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; }
.pmc-card-value { font-family: var(--serif); font-size: 26px; color: var(--navy); margin: 0; line-height: 1.2; }
.pmc-card-sub { font-size: 13px; color: var(--muted); margin: 6px 0 0; }
.pmc-breakdown-table { width: 100%; border-collapse: collapse; margin: 20px 0; background: #fff; border: 1px solid var(--line); border-radius: 12px; overflow: hidden; }
.pmc-breakdown-table th { font-size: 12px; font-weight: 700; color: var(--muted); text-align: left; padding: 12px 16px; border-bottom: 2px solid var(--line); text-transform: uppercase; letter-spacing: .05em; background: var(--cream); }
.pmc-breakdown-table td { font-size: 14px; color: var(--ink); padding: 12px 16px; border-bottom: 1px solid var(--line); }
.pmc-row-total td { font-weight: 700; border-top: 2px solid var(--navy); color: var(--navy); }
.pmc-licensed-note { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 20px; margin: 20px 0; color: #1e40af; font-size: 14px; line-height: 1.55; }
.pmc-vacancy-section { background: var(--cream); border: 1px solid var(--line); border-radius: 12px; padding: 20px; margin: 20px 0; }
.pmc-vacancy-section h4 { font-family: var(--serif); font-size: 22px; margin: 0 0 12px; color: var(--navy); }
.pmc-vacancy-row { display: flex; justify-content: space-between; gap: 16px; font-size: 14px; padding: 6px 0; color: var(--ink); }
.pmc-vacancy-row.total { font-weight: 700; border-top: 1px solid var(--line); margin-top: 8px; padding-top: 12px; font-size: 15px; color: var(--navy); }
.pmc-cta-box { background: var(--navy); border-radius: 14px; padding: 32px; text-align: center; color: #fff; margin: 28px 0 16px; }
.pmc-cta-box p { font-size: 22px; font-family: var(--serif); margin: 0 0 18px; color: #fff; }
.pmc-check-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
@media (max-width: 768px) {
  .pmc-check-grid { grid-template-columns: 1fr; }
}
.pmc-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; background: var(--navy); color: var(--gold); font-size: 10px; font-weight: 700; letter-spacing: .05em; margin-top: 4px; }
</style>

<section class="page-hero">
  <div class="wrap">
    <p class="breadcrumbs">Home / PM Turna Calculator</p>
    <p class="eyebrow">Property Manager Tool</p>
    <h1>Property Management Turna Calculator</h1>
    <p class="lead">Estimate turna costs before the site visit. Select unit details, scope of work, and get a ballpark range in 60 seconds.</p>
  </div>
</section>

<section class="section">
  <div class="wrap form-shell">
    <div class="form-card wizard-form">
      <div class="wizard-heading">
        <p class="eyebrow">Portfolio Estimator</p>
        <h3>PM Turna Cost Calculator</h3>
        <p class="step-copy">Estimate turna costs for your rental portfolio. Select unit details, check scope items, and get a ballpark range.</p>
      </div>

      <div id="pmcBody">
        <div class="form-grid" style="margin-bottom: 24px;">
          <div class="field">
            <label for="pmcUnits">Number of Units</label>
            <input id="pmcUnits" max="50" min="1" type="number" value="1">
          </div>

          <div class="field">
            <label for="pmcType">Unit Type</label>
            <select id="pmcType">
              <option value="studio">Studio</option>
              <option value="1br">1 Bedroom</option>
              <option selected value="2br">2 Bedroom</option>
              <option value="3br">3 Bedroom</option>
              <option value="4br">4 Bedroom+</option>
            </select>
          </div>

          <div class="field">
            <label for="pmcSqft">Avg. Unit Size (sq ft)</label>
            <input id="pmcSqft" max="5000" min="200" type="number" value="900">
          </div>

          <div class="field">
            <label for="pmcCondition">Condition at Turna</label>
            <select id="pmcCondition">
              <option value="good">Good - Normal Wear</option>
              <option selected value="fair">Fair - Moderate Wear</option>
              <option value="poor">Poor - Heavy Damage</option>
            </select>
          </div>

          <div class="field full">
            <label for="pmcRent">Monthly Rent per Unit ($)</label>
            <input id="pmcRent" max="10000" min="0" type="number" value="1200" placeholder="For vacancy cost calc">
          </div>
        </div>

        <div style="margin-bottom: 28px;">
          <label style="font-size: 14px; font-weight: 700; margin-bottom: 12px; display: block; text-transform: uppercase; letter-spacing: 0.05em; color: var(--navy);">Scope of Work (check all that apply)</label>
          <div id="pmcChecks" class="pmc-check-grid"></div>
        </div>

        <button id="pmcCalcBtn" class="button" type="button" style="width: 100%; min-height: 52px; font-size: 16px; cursor: pointer;">Calculate Turna Estimate</button>

        <div id="pmcResults" class="pmc-results" style="display: none; margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--line);"></div>
      </div>
    </div>
  </div>
</section>

<section class="section soft">
  <div class="wrap">
    <div class="section-head">
      <p class="eyebrow">How to use</p>
      <h2>Four steps to your portfolio estimate</h2>
    </div>
    <div class="process-cards">
      <article>
        <b>01</b>
        <h3>Select Unit Details</h3>
        <p>Choose your property type, average square footage, condition, and total unit count.</p>
      </article>
      <article>
        <b>02</b>
        <h3>Select Work Scope</h3>
        <p>Choose the specific repair and turn scopes needed for each unit in your portfolio.</p>
      </article>
      <article>
        <b>03</b>
        <h3>Review Cost & Vacancy</h3>
        <p>View itemized per-unit costs, total portfolio ranges, estimated timelines, and vacancy impact.</p>
      </article>
      <article>
        <b>04</b>
        <h3>Schedule Site Visit</h3>
        <p>Book a site visit for binding project scope development and formal written proposals.</p>
      </article>
    </div>
  </div>
</section>

<section class="section dark">
  <div class="wrap split">
    <div>
      <p class="eyebrow">Ready for exact numbers?</p>
      <h2>Get an exact quote for your property</h2>
      <p class="lead">We'll walk the units, assess scope, and give you firm pricing — no surprises.</p>
      <div style="margin-top: 24px;">
        <a class="button" href="/contact/">Book Your Free Site Visit</a>
      </div>
    </div>
    <div class="info-band" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.14);">
      <strong style="color: var(--gold); font-size: 18px;">Important Note</strong>
      <p style="margin-top: 10px; color: rgba(255,255,255,0.8); font-size: 14px; line-height: 1.6;">
        Estimates are approximate ranges based on typical Western NY market rates. Final pricing is determined after an on-site assessment by Midcity Handyman & Remodeling. Electrical and plumbing work is performed by licensed NY professionals subcontracted per code.
      </p>
    </div>
  </div>
</section>

<script>
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
      label.className = "choice-card";

      var checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.value = item.id;
      checkbox.id = "pmc_" + item.id;

      var div = document.createElement("div");

      var name = document.createElement("strong");
      name.textContent = item.name;

      var range = document.createElement("small");
      range.textContent = fmt(item.low) + " - " + fmt(item.high) + " per unit (base)";

      div.appendChild(name);
      div.appendChild(range);

      if(item.licensed){
        var lic = document.createElement("span");
        lic.className = "pmc-badge";
        lic.textContent = "LICENSED TRADE REQUIRED";
        div.appendChild(lic);
      }

      label.appendChild(checkbox);
      label.appendChild(div);
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
        results.innerHTML = '<p style="color:var(--muted);text-align:center;padding:16px;">Select at least one scope item above to see your estimate.</p>';
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
        '<h4 style="font-family:var(--serif);font-size:24px;color:var(--navy);margin:0 0 16px;">Your Turna Estimate</h4>' +
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
        '<div style="margin:24px 0;">' +
          '<div style="font-size:12px;font-weight:700;color:var(--muted);margin:0 0 10px;text-transform:uppercase;letter-spacing:.05em;">Per-Unit Cost Breakdown</div>' +
          '<table class="pmc-breakdown-table">' +
            '<thead><tr><th>Scope Item</th><th>Estimated Range</th></tr></thead>' +
            '<tbody>' + breakdownRows + '</tbody>' +
          '</table>' +
        '</div>' +
        licensedHtml +
        vacancyHtml +
        '<div class="pmc-cta-box">' +
          '<p>Ready for an exact quote for your portfolio?</p>' +
          '<a href="/contact/" class="button">Book Your Free Site Visit →</a>' +
          '<div style="font-size:14px;color:rgba(255,255,255,0.7);margin-top:14px;">Or call <a href="tel:+18337366647" style="color:var(--gold);font-weight:700;">1-833-RENO-MHR</a></div>' +
        '</div>';

      results.className = "pmc-results visible";
      results.innerHTML = html;

      setTimeout(function(){
        results.scrollIntoView({behavior:"smooth", block:"start"});
      }, 80);
    });
  }
})();
</script>

<?php require_once __DIR__.'/../includes/footer.php';?>