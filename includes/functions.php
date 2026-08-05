<?php
function e($value){ return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function config(){ static $c; return $c ??= require __DIR__.'/config.php'; }
function services(){ static $s; return $s ??= require __DIR__.'/../data/services.php'; }
function service_by_slug($slug){ foreach(services() as $s){ if($s['slug']===$slug) return $s; } return null; }
function page_url($path=''){ return rtrim(config()['site_url'],'/').'/'.ltrim($path,'/'); }
function base_path(){
  $configured = trim((string)(getenv('BASE_PATH') ?: ''), '/');
  if ($configured !== '') return '/'.$configured;
  $script = str_replace('\\','/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
  $known = ['/services/','/articles/','/contact/','/about/','/warranty/','/owner/','/licensed-remodeling-company/','/how-it-works/','/project-gallery/','/service-area/','/privacy-policy/','/reviews/','/realtors/','/property-managers/','/condo-boards/','/investors-landlords/','/pm-calculator/','/api/'];
  foreach($known as $segment){ $pos = strpos($script,$segment); if($pos!==false) return rtrim(substr($script,0,$pos),'/'); }
  $dir = rtrim(dirname($script),'/');
  return $dir==='.' || $dir==='/' ? '' : $dir;
}
function local_url($path=''){ return base_path().'/'.ltrim($path,'/'); }
function rewrite_local_urls($html){
  $base=base_path(); if($base==='') return $html;
  return preg_replace_callback('/\b(href|src|action)=("|\')\/(?!\/)([^"\']*)\2/i',function($m)use($base){return $m[1].'='.$m[2].$base.'/'.$m[3].$m[2];},$html);
}
function csrf_token(){ if(session_status()!==PHP_SESSION_ACTIVE) session_start(); return $_SESSION['csrf'] ??= bin2hex(random_bytes(24)); }
function article_data(){ return require __DIR__.'/../data/articles.php'; }
function render_email_template(array $lead): string {
  ob_start(); include __DIR__.'/email-template.php'; return (string)ob_get_clean();
}
function render_customer_email_template(array $lead): string {
  ob_start(); include __DIR__.'/customer-email-template.php'; return (string)ob_get_clean();
}

function service_areas(): array { return [
['slug'=>'akron-ny','city'=>'Akron','county'=>'Erie County','intro'=>'Your neighbor in Lockport, just 15 minutes away. Process-driven remodeling for Akron homes old and new.'],
['slug'=>'albion-ny','city'=>'Albion','county'=>'Orleans County','intro'=>'Documented remodeling and restoration for historic village homes, rentals, and growing households in Albion.'],
['slug'=>'alden-ny','city'=>'Alden','county'=>'Erie County','intro'=>'Reliable renovation support for Alden homeowners, landlords, and rural properties.'],
['slug'=>'amherst-ny','city'=>'Amherst','county'=>'Erie County','intro'=>'Kitchen, bath, basement, and whole-home remodeling delivered through a clear written process.'],
['slug'=>'batavia-ny','city'=>'Batavia','county'=>'Genesee County','intro'=>'Structured remodeling, restoration, and turnover work for Batavia homes and investment properties.'],
['slug'=>'buffalo-ny','city'=>'Buffalo','county'=>'Erie County','intro'=>'Renovation and repair support for Buffalo homes, rentals, agents, and property managers.'],
['slug'=>'cheektowaga-ny','city'=>'Cheektowaga','county'=>'Erie County','intro'=>'Practical remodeling and repair scopes for Cheektowaga homes of every age.'],
['slug'=>'clarence-ny','city'=>'Clarence','county'=>'Erie County','intro'=>'Process-driven finish work, renovations, and coordinated licensed trades for Clarence properties.'],
['slug'=>'east-aurora-ny','city'=>'East Aurora','county'=>'Erie County','intro'=>'Detailed renovation work for character homes, modern additions, and carefully planned upgrades.'],
['slug'=>'grand-island-ny','city'=>'Grand Island','county'=>'Erie County','intro'=>'Reliable residential remodeling and restoration serving Grand Island homeowners and landlords.'],
['slug'=>'hamburg-ny','city'=>'Hamburg','county'=>'Erie County','intro'=>'Kitchen, bathroom, basement, compliance, and storm repair work for Hamburg properties.'],
['slug'=>'lancaster-ny','city'=>'Lancaster','county'=>'Erie County','intro'=>'Written scopes and accountable project delivery for Lancaster remodeling projects.'],
['slug'=>'lewiston-ny','city'=>'Lewiston','county'=>'Niagara County','intro'=>'Careful remodeling and restoration for Lewiston homes, rentals, and investment properties.'],
['slug'=>'lockport-ny','city'=>'Lockport','county'=>'Niagara County','intro'=>'Our home base. Directly managed remodeling and restoration throughout Lockport.'],
['slug'=>'niagara-falls-ny','city'=>'Niagara Falls','county'=>'Niagara County','intro'=>'Fast, documented renovation, turnover, compliance, and restoration work across Niagara Falls.'],
['slug'=>'north-tonawanda-ny','city'=>'North Tonawanda','county'=>'Niagara County','intro'=>'Residential remodeling and property repair with clear scopes and photo updates.'],
['slug'=>'orchard-park-ny','city'=>'Orchard Park','county'=>'Erie County','intro'=>'Premium, process-led remodeling for Orchard Park kitchens, bathrooms, basements, and interiors.'],
['slug'=>'tonawanda-ny','city'=>'Tonawanda','county'=>'Erie County','intro'=>'Dependable renovation and repair services for Tonawanda homeowners and rental operators.'],
['slug'=>'west-seneca-ny','city'=>'West Seneca','county'=>'Erie County','intro'=>'Full-scope remodeling and restoration backed by documentation and formal closeout.'],
['slug'=>'williamsville-ny','city'=>'Williamsville','county'=>'Erie County','intro'=>'Detailed remodeling and finish work for Williamsville homes and investment properties.']
]; }
