<?php
/**
 * Plugin Name: Grid de Cursos (Carrossel)
 * Description: Exibe grid/carrossel de cursos via shortcode [grid_cursos].
 * Version:     2.5.1
 * Author:      Vausnicler Furin
 * Author URI:  https://vausnicler.dev/
 * Plugin URI:  https://github.com/vausnicler/grid-de-cursos-carrossel
 * License:     GPL-2.0
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: grid-de-cursos-carrossel
 *
 * v2.5: Setas sem borda redonda, com mais destaque visual
 */
if ( ! defined('ABSPATH') ) exit;
function gdc_color_defaults() {
    return [
        'badge_grad'          => '#0F4BD7',
        'badge_grad_txt'      => '#ffffff',
        'badge_pos_txt'       => '#ffffff',
        'badge_prof_txt'      => '#ffffff',
        'badge_tec_txt'       => '#ffffff',
        'badge_pos'           => '#0EA5E9',
        'badge_prof'          => '#16a34a',
        'badge_tec'           => '#dc2626',
        'badge_ead_bg'        => '#ffffff',
        'badge_eadsemi_bg'    => '#ffffff',
        'badge_presencial_bg' => '#ffffff',
        'badge_ead_txt'       => '#054B7A',
        'badge_eadsemi_txt'   => '#054B7A',
        'badge_presencial_txt'=> '#054B7A',
        'btn_bg'              => '#00467A',
        'btn_txt'             => '#ffffff',
        'saiba_txt'           => '#ffffff',
        'saiba_hover_bg'      => '#0B4F8A',
        'card_fallback_top'   => '#1e3a5f',
        'card_fallback_bot'   => '#091929',
        'card_dark_bg'        => '#1c1c2e',
        'section_title'       => '#0f172a',
        'card_title_txt'      => '#ffffff',
        'arrow_bg'            => '#0F4BD7',
        'arrow_txt'           => '#ffffff',
        'saiba_border'        => '#ffffff',
        'saiba_bg'            => '#ffffff',
    ];
}
function gdc_overlay_defaults() {
    return [
        'op1' => '4',
        'op2' => '8',
        'op3' => '55',
        'op4' => '82',
    ];
}
add_action('admin_init', function(){
    register_setting('gdc_group','gdc_courses',  ['type'=>'array','sanitize_callback'=>'gdc_sanitize_courses','default'=>[]]);
    register_setting('gdc_group','gdc_more_url', ['type'=>'string','sanitize_callback'=>'esc_url_raw','default'=>'#']);
    register_setting('gdc_group','gdc_more_text',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'Explorar outras graduações']);
    register_setting('gdc_group','gdc_font_size',['type'=>'string','sanitize_callback'=>'gdc_sanitize_font_size','default'=>'16px']);
    register_setting('gdc_group','gdc_colors',   ['type'=>'array','sanitize_callback'=>'gdc_sanitize_colors','default'=>gdc_color_defaults()]);
    register_setting('gdc_group','gdc_overlay',  ['type'=>'array','sanitize_callback'=>'gdc_sanitize_overlay','default'=>gdc_overlay_defaults()]);
    register_setting('gdc_group','gdc_hover_escurecer',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'1']);
    register_setting('gdc_group','gdc_show_btn',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'1']);
    register_setting('gdc_group','gdc_font_scale',['type'=>'string','sanitize_callback'=>'gdc_sanitize_font_scale','default'=>'1']);
    register_setting('gdc_group','gdc_fonts',['type'=>'array','sanitize_callback'=>'gdc_sanitize_fonts','default'=>gdc_font_defaults()]);
    register_setting('gdc_group','gdc_titulo',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_padding',['type'=>'array','sanitize_callback'=>'gdc_sanitize_padding','default'=>['top'=>'0','bot'=>'0']]);
    register_setting('gdc_group','gdc_align',['type'=>'array','sanitize_callback'=>'gdc_sanitize_align_multi','default'=>gdc_align_defaults()]);
    register_setting('gdc_group','gdc_weights',['type'=>'array','sanitize_callback'=>'gdc_sanitize_weights','default'=>gdc_weight_defaults()]);
    register_setting('gdc_group','gdc_saiba_bg_alpha',['type'=>'string','sanitize_callback'=>'absint','default'=>'8']);
    register_setting('gdc_group','gdc_saiba_radius', ['type'=>'string','sanitize_callback'=>'absint','default'=>'6']);
    register_setting('gdc_group','gdc_btn_radius',   ['type'=>'string','sanitize_callback'=>'absint','default'=>'5']);
    register_setting('gdc_group','gdc_badge_radius', ['type'=>'string','sanitize_callback'=>'absint','default'=>'6']);
    register_setting('gdc_group','gdc_badgemod_radius',['type'=>'string','sanitize_callback'=>'absint','default'=>'4']);
    register_setting('gdc_group','gdc_auto_posts',  ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'0']);
    register_setting('gdc_group','gdc_auto_tag',    ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_auto_count',  ['type'=>'string','sanitize_callback'=>'absint','default'=>'10']);
    register_setting('gdc_group','gdc_auto_post_type',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'post']);
    register_setting('gdc_group','gdc_auto_badge',     ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_auto_modalidade',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_auto_saiba',     ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'Saiba mais']);
    register_setting('gdc_group','gdc_show_saiba',          ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'1']);
    register_setting('gdc_group','gdc_auto_badge_custom',   ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_auto_modal_custom',   ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'']);
    register_setting('gdc_group','gdc_arrow_radius',['type'=>'string','sanitize_callback'=>'absint','default'=>'6']);
    register_setting('gdc_group','gdc_arrow_nobg',  ['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'0']);
    register_setting('gdc_group','gdc_hover_scale',['type'=>'string','sanitize_callback'=>'sanitize_text_field','default'=>'0']);
});
function gdc_sanitize_weights($input){
    $valid=[100,200,300,400,500,600,700,800,900];
    $out=[];
    foreach(gdc_weight_defaults() as $key=>$def){
        $val=intval($input[$key]??$def);
        $out[$key]=in_array($val,$valid,true)?$val:intval($def);
    }
    return $out;
}

function gdc_align_defaults(){
    return ['badge'=>'center','nome'=>'left','saiba'=>'center'];
}

function gdc_sanitize_align_multi($input){
    $out=[];
    foreach(gdc_align_defaults() as $key=>$def){
        $v = sanitize_text_field($input[$key]??$def);
        $out[$key] = in_array($v,['left','center','right'],true) ? $v : $def;
    }
    return $out;
}

function gdc_sanitize_padding($input){
    return [
        'top' => max(0, min(200, intval($input['top']??0))),
        'bot' => max(0, min(200, intval($input['bot']??0))),
    ];
}

function gdc_sanitize_font_size($v){
    $v = sanitize_text_field($v);
    return preg_match('/^\d+(\.\d+)?(px|rem|em|pt|%)$/',$v) ? $v : '16px';
}
function gdc_font_defaults() {
    return [
        'titulo'    => '28',
        'badge'     => '11',
        'badge_mod' => '10',
        'saiba'     => '13',
        'nome'      => '14',
        'btn'       => '15',
        'seta'      => '28',
        'saiba_pos' => '58',
    ];
}

function gdc_weight_defaults() {
    return [
        'badge'     => '800',
        'badge_mod' => '700',
        'saiba'     => '700',
        'nome'      => '700',
        'btn'       => '500',
        'titulo'    => '700',
    ];
}
function gdc_sanitize_font_scale($v){
    $v = sanitize_text_field($v);
    $f = floatval(str_replace(',','.',$v));
    if($f >= 0.5 && $f <= 2.0) return number_format($f,2,'.','');
    return '1.00';
}
function gdc_sanitize_fonts($input){
    $defaults = gdc_font_defaults(); $out=[];
    foreach($defaults as $key=>$def){
        $val = intval($input[$key]??$def);
        $out[$key] = max(6, min(80, $val));
    }
    return $out;
}
function gdc_sanitize_colors($input){
    $defaults = gdc_color_defaults(); $out=[];
    foreach($defaults as $key=>$def){
        $val = sanitize_text_field($input[$key]??$def);
        $out[$key] = preg_match('/^#[0-9a-fA-F]{3,6}$/',$val) ? $val : $def;
    }
    return $out;
}
function gdc_sanitize_overlay($input){
    $defaults = gdc_overlay_defaults(); $out=[];
    foreach($defaults as $key=>$def){
        $val = intval($input[$key]??$def);
        $out[$key] = max(0,min(100,$val));
    }
    return $out;
}
function gdc_sanitize_courses($input){
    $valid_badges=['','grad','pos','prof','tec'];
    $valid_mods  =['','ead','eadsemipresencial','presencial'];
    $san=[];
    if(is_array($input)){
        foreach($input as $row){
            if(empty($row['title'])&&empty($row['url'])&&empty($row['image'])) continue;
            $badge=in_array(($row['badge']??''),$valid_badges,true)?($row['badge']??''):'grad';
            $mod  =strtolower(trim($row['modalidade']??''));
            $mod  =in_array($mod,$valid_mods,true)?$mod:'';
            $san[]=['title'=>sanitize_text_field($row['title']??''),'url'=>esc_url_raw($row['url']??''),
                    'image'=>esc_url_raw($row['image']??''),'badge'=>$badge,'modalidade'=>$mod];
        }
    }
    return $san;
}
add_action('admin_menu',function(){
    add_menu_page('Grid de Cursos','Grid de Cursos','manage_options','gdc-cursos','gdc_admin_page','dashicons-screenoptions',25);
    add_submenu_page('gdc-cursos','Instruções','Instruções','manage_options','gdc-cursos-help','gdc_help_page');
});
function gdc_color_field($label,$key,$colors){
    $val=esc_attr($colors[$key]??gdc_color_defaults()[$key]??'#000000');
    echo '<div class="gdc-cf">';
    echo '<label>'.$label.'</label>';
    echo '<div class="gdc-cf-row">';
    echo '<div class="gdc-swatch" id="gdc_sw_'.$key.'" style="background:'.$val.'">';
    echo '<input type="color" name="gdc_colors['.$key.']" id="gdc_colors_'.$key.'" value="'.$val.'">';
    echo '</div>';
    echo '<input type="text" class="gdc-hex" id="gdc_hex_'.$key.'" value="'.$val.'" maxlength="7" placeholder="#000000">';
    echo '</div></div>';
}
function gdc_admin_page(){
    if(!current_user_can('manage_options')) return;
    $courses    = get_option('gdc_courses',[]);
    $more_url   = get_option('gdc_more_url','#');
    $more_txt   = get_option('gdc_more_text','Explorar outras graduações');
    $font_size  = get_option('gdc_font_size','16px');
    $colors     = wp_parse_args(get_option('gdc_colors',[]),gdc_color_defaults());
    $overlay    = wp_parse_args(get_option('gdc_overlay',[]),gdc_overlay_defaults());
    $ov         = array_map('intval',$overlay);
    $gdc_titulo = get_option('gdc_titulo','');
    $gdc_pad     = wp_parse_args(get_option('gdc_padding',[]),['top'=>0,'bot'=>0]);
    $gdc_align   = wp_parse_args(get_option('gdc_align',[]),gdc_align_defaults());
    $gdc_weights     = wp_parse_args(get_option('gdc_weights',[]),gdc_weight_defaults());
    $fw              = array_map('intval',$gdc_weights);
    $saiba_bg_alpha  = max(0,min(100,intval(get_option('gdc_saiba_bg_alpha','8'))));
    $saiba_radius    = max(0,min(30,intval(get_option('gdc_saiba_radius','6'))));
    $arrow_radius    = max(0,min(30,intval(get_option('gdc_arrow_radius','6'))));
    $arrow_nobg      = get_option('gdc_arrow_nobg','0');
    $arrow_radius    = max(0,min(30,intval(get_option('gdc_arrow_radius','6'))));
    $arrow_nobg      = get_option('gdc_arrow_nobg','0');
    $btn_radius      = max(0,min(30,intval(get_option('gdc_btn_radius','5'))));
    $badge_radius    = max(0,min(30,intval(get_option('gdc_badge_radius','6'))));
    $badgemod_radius = max(0,min(30,intval(get_option('gdc_badgemod_radius','4'))));
    /* converte hex para rgba com a opacidade configurada */
    $saiba_bg_hex   = $colors['saiba_bg'] ?? '#ffffff';
    $saiba_bg_r     = hexdec(substr(ltrim($saiba_bg_hex,'#'),0,2));
    $saiba_bg_g     = hexdec(substr(ltrim($saiba_bg_hex,'#'),2,2));
    $saiba_bg_b     = hexdec(substr(ltrim($saiba_bg_hex,'#'),4,2));
    $saiba_bg_rgba  = 'rgba('.$saiba_bg_r.','.$saiba_bg_g.','.$saiba_bg_b.','.number_format($saiba_bg_alpha/100,2).')';
    $hover_scale = get_option('gdc_hover_scale','0');
    $hover_esc   = get_option('gdc_hover_escurecer','1');
    $show_btn   = get_option('gdc_show_btn','1');
    $font_scale = get_option('gdc_font_scale','1');
    $fonts      = wp_parse_args(get_option('gdc_fonts',[]),gdc_font_defaults());
    ?>
    <div class="wrap">
    <h1>🎓 Grid de Cursos <span style="font-size:13px;font-weight:400;color:#888">v2.5</span></h1>
    <p>Com <strong>6 ou mais cursos</strong> o carrossel é ativado automaticamente em todos os dispositivos. Com <strong>5 cursos</strong>, o carrossel é ativado apenas no mobile (≤768px); no desktop exibe grid fixo.</p>
    <style>
    .gdc-admin-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px 24px}
    .gdc-cf{display:flex;flex-direction:column;gap:5px}
    .gdc-cf label{font-size:13px;font-weight:500;color:#3c434a}
    .gdc-cf-row{display:flex;align-items:center;gap:8px}
    .gdc-swatch{width:34px;height:34px;border-radius:6px;border:1px solid #ccc;overflow:hidden;position:relative;flex-shrink:0;cursor:pointer}
    .gdc-swatch input[type=color]{position:absolute;inset:-4px;width:calc(100% + 8px);height:calc(100% + 8px);opacity:0;cursor:pointer}
    .gdc-hex{width:90px;font-family:monospace;font-size:13px;padding:5px 7px;border:1px solid #ccc;border-radius:4px}
    .gdc-preview{display:flex;height:44px;border-radius:6px;overflow:hidden;border:1px solid #ddd;margin-bottom:16px}
    .gdc-preview-seg{flex:1;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;letter-spacing:.3px;color:#fff;text-shadow:0 1px 3px rgba(0,0,0,.5)}
    hr.gdc-hr{margin:16px 0;border:none;border-top:1px solid #ddd}
    .gdc-box{background:#f9f9f9;border:1px solid #e5e5e5;border-radius:6px;padding:14px 16px;margin-bottom:14px}
    .gdc-box h3{font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:#555;margin:0 0 12px;padding-bottom:6px;border-bottom:1px solid #e0e0e0}
    .gdc-box h4{font-size:12px;font-weight:600;color:#666;margin:12px 0 6px;text-transform:uppercase;letter-spacing:.4px}
    .gdc-ov-wrap{position:relative;height:80px;border-radius:8px;overflow:hidden;margin-bottom:14px;background:linear-gradient(135deg,#1e3a5f,#091929)}
    .gdc-ov-layer{position:absolute;inset:0}
    .gdc-ov-label{position:absolute;bottom:8px;left:10px;color:#fff;font-size:11px;font-weight:700;text-shadow:0 1px 4px rgba(0,0,0,.8);letter-spacing:.3px}
    .gdc-slider-row{display:flex;align-items:center;gap:10px;margin-bottom:8px}
    .gdc-slider-row label{font-size:12px;color:#555;width:140px;flex-shrink:0}
    .gdc-slider-row input[type=range]{flex:1}
    .gdc-slider-row .gdc-oval{font-size:12px;font-family:monospace;width:36px;text-align:right;color:#333}
    .gdc-btn-preview{display:flex;gap:12px;align-items:center;margin-bottom:14px;flex-wrap:wrap}
    .gdc-btn-prev-item{padding:7px 18px;border-radius:5px;font-size:13px;font-weight:600;border:none;cursor:default}
    .gdc-btn-prev-saiba{padding:6px 18px;border-radius:999px;font-size:13px;font-weight:700;border:2px solid rgba(255,255,255,.8);background:rgba(255,255,255,.08)}
    .gdc-arrow-preview{display:flex;gap:8px;align-items:center;margin-bottom:14px}
    .gdc-arrow-prev-btn{width:44px;height:44px;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:700;cursor:default;box-shadow:0 4px 12px rgba(0,0,0,.25)}
    </style>
    <form method="post" action="options.php">
        <?php settings_fields('gdc_group'); ?>
        <h2 class="title">Aparência</h2>
        <table class="form-table">
            <tr>
                <th><label for="gdc_titulo">Título do grid</label></th>
                <td>
                    <input type="text" id="gdc_titulo" name="gdc_titulo" class="regular-text" value="<?php echo esc_attr($gdc_titulo); ?>" placeholder="Ex.: Cursos em Destaque">
                    <p class="description">Deixe em branco para não exibir título.</p>
                </td>
            </tr>
            <tr>
                <th><label>Espaçamento interno (padding)</label></th>
                <td>
                    <div style="display:flex;gap:24px;flex-wrap:wrap">
                        <label style="display:flex;align-items:center;gap:8px">
                            Topo
                            <input type="range" name="gdc_padding[top]" min="0" max="200" step="4"
                                   value="<?php echo intval($gdc_pad['top']); ?>"
                                   oninput="document.getElementById('gdc_pad_top_lbl').textContent=this.value+'px'"
                                   style="width:160px;vertical-align:middle">
                            <span id="gdc_pad_top_lbl" style="font-family:monospace;min-width:36px"><?php echo intval($gdc_pad['top']); ?>px</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:8px">
                            Base
                            <input type="range" name="gdc_padding[bot]" min="0" max="200" step="4"
                                   value="<?php echo intval($gdc_pad['bot']); ?>"
                                   oninput="document.getElementById('gdc_pad_bot_lbl').textContent=this.value+'px'"
                                   style="width:160px;vertical-align:middle">
                            <span id="gdc_pad_bot_lbl" style="font-family:monospace;min-width:36px"><?php echo intval($gdc_pad['bot']); ?>px</span>
                        </label>
                    </div>
                    <p class="description">Controla o espaço interno acima e abaixo do grid.</p>
                </td>
            </tr>
            <tr>
                <th><label>Alinhamento — Badge (tipo + modalidade)</label></th>
                <td>
                    <div style="display:flex;gap:16px">
                        <?php foreach(['left'=>'⬅ Esquerda','center'=>'↔ Centro','right'=>'➡ Direita'] as $val=>$lbl): ?>
                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer">
                            <input type="radio" name="gdc_align[badge]" value="<?php echo $val;?>" <?php checked($gdc_align['badge'],$val);?>>
                            <?php echo $lbl;?>
                        </label>
                        <?php endforeach;?>
                    </div>
                </td>
            </tr>
            <tr>
                <th><label>Alinhamento — Nome do curso</label></th>
                <td>
                    <div style="display:flex;gap:16px">
                        <?php foreach(['left'=>'⬅ Esquerda','center'=>'↔ Centro','right'=>'➡ Direita'] as $val=>$lbl): ?>
                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer">
                            <input type="radio" name="gdc_align[nome]" value="<?php echo $val;?>" <?php checked($gdc_align['nome'],$val);?>>
                            <?php echo $lbl;?>
                        </label>
                        <?php endforeach;?>
                    </div>
                </td>
            </tr>
            <tr>
                <th><label>Alinhamento — Botão "Saiba mais"</label></th>
                <td>
                    <div style="display:flex;gap:16px">
                        <?php foreach(['left'=>'⬅ Esquerda','center'=>'↔ Centro','right'=>'➡ Direita'] as $val=>$lbl): ?>
                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer">
                            <input type="radio" name="gdc_align[saiba]" value="<?php echo $val;?>" <?php checked($gdc_align['saiba'],$val);?>>
                            <?php echo $lbl;?>
                        </label>
                        <?php endforeach;?>
                    </div>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_font_size">Tamanho de fonte base</label></th>
                <td>
                    <input type="text" id="gdc_font_size" name="gdc_font_size" value="<?php echo esc_attr($font_size); ?>" class="small-text" placeholder="16px">
                    <p class="description">Isola o grid da herança do tema. Ex: <code>16px</code>, <code>1rem</code></p>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_hover_escurecer">Efeito hover — escurecer outros cards</label></th>
                <td>
                    <label>
                        <input type="checkbox" id="gdc_hover_escurecer" name="gdc_hover_escurecer" value="1" <?php checked($hover_esc,'1'); ?>>
                        Ativar escurecimento dos cards não selecionados ao passar o mouse
                    </label>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_hover_scale">Efeito hover — expandir card</label></th>
                <td>
                    <label>
                        <input type="checkbox" id="gdc_hover_scale" name="gdc_hover_scale" value="1" <?php checked($hover_scale,'1'); ?>>
                        Expandir levemente o card ao passar o mouse (scale)
                    </label>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_show_btn">Botão inferior</label></th>
                <td>
                    <label>
                        <input type="checkbox" id="gdc_show_btn" name="gdc_show_btn" value="1" <?php checked($show_btn,'1'); ?>>
                        Exibir botão inferior ("Explorar outras graduações")
                    </label>
                </td>
            </tr>
            <tr>
                <th style="padding-top:16px"><strong>Tamanhos de fonte</strong></th>
                <td style="padding-top:16px"><p class="description">Ajuste individual de cada elemento do grid.</p></td>
            </tr>
            <?php
            $font_fields = [
                ['titulo',    'Título da seção',       8,  80],
                ['badge',     'Badge tipo de curso',   6,  30],
                ['badge_mod', 'Badge modalidade',      6,  30],
                ['saiba',     'Botão "Saiba mais"',    6,  30],
                ['nome',      'Nome do curso no card', 6,  30],
                ['btn',       'Botão inferior',        6,  40],
                ['seta',      'Seta do carrossel',     10, 60],
                ['saiba_pos', 'Posição vertical "Saiba mais" (%)', 10, 90],
            ];
            foreach($font_fields as [$key,$label,$min,$max]):
            ?>
            <tr>
                <th><label for="gdc_fonts_<?php echo $key;?>"><?php echo $label;?></label></th>
                <td>
                    <input type="range" id="gdc_fonts_<?php echo $key;?>" name="gdc_fonts[<?php echo $key;?>]"
                           min="<?php echo $min;?>" max="<?php echo $max;?>" step="1"
                           value="<?php echo intval($fonts[$key]);?>"
                           oninput="document.getElementById('gdc_fonts_<?php echo $key;?>_lbl').textContent=this.value+'px'"
                           style="width:200px;vertical-align:middle">
                    <span id="gdc_fonts_<?php echo $key;?>_lbl" style="font-family:monospace;margin-left:6px"><?php echo intval($fonts[$key]);?>px</span>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <hr class="gdc-hr">
        <h2 class="title">⚖️ Peso das fontes</h2>
        <table class="form-table">
            <tr>
                <th><label>Título da seção</label></th>
                <td>
                    <select name="gdc_weights[titulo]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['titulo']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['titulo']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['titulo']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['titulo']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['titulo']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['titulo']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['titulo']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['titulo']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['titulo']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
            <tr>
                <th><label>Badge tipo de curso</label></th>
                <td>
                    <select name="gdc_weights[badge]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['badge']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['badge']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['badge']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['badge']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['badge']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['badge']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['badge']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['badge']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['badge']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
            <tr>
                <th><label>Badge modalidade</label></th>
                <td>
                    <select name="gdc_weights[badge_mod]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['badge_mod']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['badge_mod']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['badge_mod']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['badge_mod']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['badge_mod']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['badge_mod']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['badge_mod']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['badge_mod']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['badge_mod']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
            <tr>
                <th><label>Botão "Saiba mais"</label></th>
                <td>
                    <select name="gdc_weights[saiba]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['saiba']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['saiba']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['saiba']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['saiba']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['saiba']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['saiba']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['saiba']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['saiba']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['saiba']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
            <tr>
                <th><label>Nome do curso no card</label></th>
                <td>
                    <select name="gdc_weights[nome]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['nome']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['nome']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['nome']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['nome']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['nome']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['nome']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['nome']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['nome']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['nome']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
            <tr>
                <th><label>Botão inferior</label></th>
                <td>
                    <select name="gdc_weights[btn]" style="min-width:100px"><option value='100' <?php selected(intval($gdc_weights['btn']),100); ?>>100</option><option value='200' <?php selected(intval($gdc_weights['btn']),200); ?>>200</option><option value='300' <?php selected(intval($gdc_weights['btn']),300); ?>>300</option><option value='400' <?php selected(intval($gdc_weights['btn']),400); ?>>400</option><option value='500' <?php selected(intval($gdc_weights['btn']),500); ?>>500</option><option value='600' <?php selected(intval($gdc_weights['btn']),600); ?>>600</option><option value='700' <?php selected(intval($gdc_weights['btn']),700); ?>>700</option><option value='800' <?php selected(intval($gdc_weights['btn']),800); ?>>800</option><option value='900' <?php selected(intval($gdc_weights['btn']),900); ?>>900</option></select>
                    <span style="font-size:12px;color:#888;margin-left:8px">font-weight</span>
                </td>
            </tr>
        </table>

        <hr class="gdc-hr">
        <h2 class="title">🎨 Cores</h2>
        <div class="gdc-preview" id="gdc-preview">
            <div class="gdc-preview-seg" id="gpv-grad"  style="background:<?php echo esc_attr($colors['badge_grad']); ?>">GRAD</div>
            <div class="gdc-preview-seg" id="gpv-pos"   style="background:<?php echo esc_attr($colors['badge_pos']); ?>">PÓS</div>
            <div class="gdc-preview-seg" id="gpv-prof"  style="background:<?php echo esc_attr($colors['badge_prof']); ?>">PROF</div>
            <div class="gdc-preview-seg" id="gpv-tec"   style="background:<?php echo esc_attr($colors['badge_tec']); ?>">TÉC</div>
            <div class="gdc-preview-seg" id="gpv-ead"   style="background:<?php echo esc_attr($colors['badge_ead_bg']); ?>;color:<?php echo esc_attr($colors['badge_ead_txt']); ?>;text-shadow:none;font-size:9px">EAD</div>
            <div class="gdc-preview-seg" id="gpv-semi"  style="background:<?php echo esc_attr($colors['badge_eadsemi_bg']); ?>;color:<?php echo esc_attr($colors['badge_eadsemi_txt']); ?>;text-shadow:none;font-size:8px">SEMI</div>
            <div class="gdc-preview-seg" id="gpv-pres"  style="background:<?php echo esc_attr($colors['badge_presencial_bg']); ?>;color:<?php echo esc_attr($colors['badge_presencial_txt']); ?>;text-shadow:none;font-size:8px">PRES</div>
            <div class="gdc-preview-seg" id="gpv-btn"   style="background:<?php echo esc_attr($colors['btn_bg']); ?>;color:<?php echo esc_attr($colors['btn_txt']); ?>;text-shadow:none">BOTÃO</div>
            <div class="gdc-preview-seg" id="gpv-title" style="background:<?php echo esc_attr($colors['section_title']); ?>">TÍTULO</div>
        </div>
        <div class="gdc-box">
            <h3>Badges — tipo de curso</h3>
            <div class="gdc-admin-grid">
                <?php
                gdc_color_field('Graduação — fundo',          'badge_grad',     $colors);
                gdc_color_field('Graduação — texto',           'badge_grad_txt',  $colors);
                gdc_color_field('Pós-Graduação — fundo',      'badge_pos',       $colors);
                gdc_color_field('Pós-Graduação — texto',      'badge_pos_txt',   $colors);
                gdc_color_field('Profissionalizante — fundo', 'badge_prof',      $colors);
                gdc_color_field('Profissionalizante — texto', 'badge_prof_txt',  $colors);
                gdc_color_field('Técnico — fundo',            'badge_tec',       $colors);
                gdc_color_field('Técnico — texto',            'badge_tec_txt',   $colors);
                ?>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Badges — modalidade</h3>
            <h4>EAD</h4>
            <div class="gdc-admin-grid">
                <?php gdc_color_field('Fundo','badge_ead_bg',$colors); gdc_color_field('Texto','badge_ead_txt',$colors); ?>
            </div>
            <h4>EAD Semipresencial</h4>
            <div class="gdc-admin-grid">
                <?php gdc_color_field('Fundo','badge_eadsemi_bg',$colors); gdc_color_field('Texto','badge_eadsemi_txt',$colors); ?>
            </div>
            <h4>Presencial</h4>
            <div class="gdc-admin-grid">
                <?php gdc_color_field('Fundo','badge_presencial_bg',$colors); gdc_color_field('Texto','badge_presencial_txt',$colors); ?>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Botões</h3>
            <div class="gdc-btn-preview">
                <div>
                    <p style="font-size:11px;color:#888;margin:0 0 4px">Botão inferior</p>
                    <div class="gdc-btn-prev-item" id="gpv-btn-preview"
                         style="background:<?php echo esc_attr($colors['btn_bg']);?>;color:<?php echo esc_attr($colors['btn_txt']);?>">
                        Explorar graduações
                    </div>
                </div>
                <div>
                    <p style="font-size:11px;color:#888;margin:0 0 4px">Saiba mais (normal)</p>
                    <div style="background:#555;padding:8px 14px;border-radius:8px">
                        <span class="gdc-btn-prev-saiba" id="gpv-saiba-preview" style="color:<?php echo esc_attr($colors['saiba_txt']);?>">Saiba mais</span>
                    </div>
                </div>
                <div>
                    <p style="font-size:11px;color:#888;margin:0 0 4px">Saiba mais (hover)</p>
                    <div style="background:#555;padding:8px 14px;border-radius:8px">
                        <span class="gdc-btn-prev-saiba" id="gpv-saiba-hover-preview" style="background:rgba(255,255,255,.92);border-color:#fff;color:<?php echo esc_attr($colors['saiba_hover_bg']);?>">Saiba mais</span>
                    </div>
                </div>
            </div>
            <div class="gdc-admin-grid">
                <?php
                gdc_color_field('Botão inferior — fundo',           'btn_bg',        $colors);
                gdc_color_field('Botão inferior — texto',           'btn_txt',        $colors);
                gdc_color_field('"Saiba mais" — cor do texto',      'saiba_txt',      $colors);
                gdc_color_field('"Saiba mais" — cor do texto (hover)','saiba_hover_bg', $colors);
                gdc_color_field('"Saiba mais" — cor da borda',        'saiba_border',   $colors);
                gdc_color_field('"Saiba mais" — cor do fundo',         'saiba_bg',       $colors);
                ?>
            </div>
            <div style="margin-top:10px;display:flex;align-items:center;gap:10px">
                <label style="font-size:13px;font-weight:500;color:#3c434a">"Saiba mais" — opacidade do fundo</label>
                <input type="range" name="gdc_saiba_bg_alpha" min="0" max="100" step="1"
                       value="<?php echo $saiba_bg_alpha; ?>"
                       oninput="document.getElementById('saiba_bg_alpha_lbl').textContent=this.value+'%'"
                       style="width:160px;vertical-align:middle">
                <span id="saiba_bg_alpha_lbl" style="font-family:monospace;min-width:36px"><?php echo $saiba_bg_alpha; ?>%</span>
            </div>
            <div style="margin-top:10px;display:flex;align-items:center;gap:10px">
                <label style="font-size:13px;font-weight:500;color:#3c434a">"Saiba mais" — border-radius</label>
                <input type="range" name="gdc_saiba_radius" min="0" max="30" step="1"
                       value="<?php echo $saiba_radius; ?>"
                       oninput="document.getElementById('saiba_radius_lbl').textContent=this.value+'px'"
                       style="width:160px;vertical-align:middle">
                <span id="saiba_radius_lbl" style="font-family:monospace;min-width:40px"><?php echo $saiba_radius; ?>px</span>
            </div>
            <!-- radius botão inferior -->
            <div style="margin-top:10px;display:flex;align-items:center;gap:10px">
                <label style="font-size:13px;font-weight:500;color:#3c434a">Botão inferior — border-radius</label>
                <input type="range" name="gdc_btn_radius" min="0" max="30" step="1"
                       value="<?php echo $btn_radius; ?>"
                       oninput="document.getElementById('btn_radius_lbl').textContent=this.value+'px'"
                       style="width:160px;vertical-align:middle">
                <span id="btn_radius_lbl" style="font-family:monospace;min-width:40px"><?php echo $btn_radius; ?>px</span>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Badges — border-radius</h3>
            <div style="display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;align-items:center;gap:10px">
                    <label style="font-size:13px;font-weight:500;color:#3c434a;width:180px">Badge tipo de curso</label>
                    <input type="range" name="gdc_badge_radius" min="0" max="30" step="1"
                           value="<?php echo $badge_radius; ?>"
                           oninput="document.getElementById('badge_radius_lbl').textContent=this.value+'px'"
                           style="width:160px;vertical-align:middle">
                    <span id="badge_radius_lbl" style="font-family:monospace;min-width:40px"><?php echo $badge_radius; ?>px</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                    <label style="font-size:13px;font-weight:500;color:#3c434a;width:180px">Badge modalidade</label>
                    <input type="range" name="gdc_badgemod_radius" min="0" max="30" step="1"
                           value="<?php echo $badgemod_radius; ?>"
                           oninput="document.getElementById('badgemod_radius_lbl').textContent=this.value+'px'"
                           style="width:160px;vertical-align:middle">
                    <span id="badgemod_radius_lbl" style="font-family:monospace;min-width:40px"><?php echo $badgemod_radius; ?>px</span>
                </div>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Setas do carrossel</h3>
            <div class="gdc-arrow-preview">
                <div class="gdc-arrow-prev-btn" id="gpv-arrow-preview"
                     style="background:<?php echo esc_attr($colors['arrow_bg']);?>;color:<?php echo esc_attr($colors['arrow_txt']);?>">‹</div>
                <div class="gdc-arrow-prev-btn" id="gpv-arrow-preview2"
                     style="background:<?php echo esc_attr($colors['arrow_bg']);?>;color:<?php echo esc_attr($colors['arrow_txt']);?>">›</div>
                <span style="font-size:12px;color:#888">Prévia das setas</span>
            </div>
            <div class="gdc-admin-grid">
                <?php
                gdc_color_field('Fundo da seta', 'arrow_bg',  $colors);
                gdc_color_field('Ícone da seta', 'arrow_txt', $colors);
                ?>
            </div>
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;align-items:center;gap:10px">
                    <label style="font-size:13px;font-weight:500;color:#3c434a;width:140px">Border-radius</label>
                    <input type="range" name="gdc_arrow_radius" min="0" max="30" step="1"
                           value="<?php echo $arrow_radius; ?>"
                           oninput="document.getElementById('arrow_radius_lbl').textContent=this.value+'px'"
                           style="width:160px;vertical-align:middle">
                    <span id="arrow_radius_lbl" style="font-family:monospace;min-width:40px"><?php echo $arrow_radius; ?>px</span>
                </div>
                <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#3c434a">
                    <input type="checkbox" name="gdc_arrow_nobg" value="1" <?php checked($arrow_nobg,'1'); ?>>
                    Remover fundo das setas (apenas ícone visível)
                </label>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Card sem imagem — gradiente de fundo</h3>
            <div class="gdc-admin-grid">
                <?php
                gdc_color_field('Cor do topo',             'card_fallback_top', $colors);
                gdc_color_field('Cor da base',             'card_fallback_bot', $colors);
                gdc_color_field('Fundo base escuro do card','card_dark_bg',     $colors);
                ?>
            </div>
        </div>
        <div class="gdc-box">
            <h3>Texto</h3>
            <div class="gdc-admin-grid">
                <?php gdc_color_field('Cor do título da seção','section_title',$colors); ?>
                <?php gdc_color_field('Cor do título do card', 'card_title_txt',$colors); ?>
            </div>
        </div>
        <hr class="gdc-hr">
        <h2 class="title">🌑 Sombreado do card</h2>
        <p style="margin-bottom:10px;color:#555;font-size:13px">Controla a opacidade do gradiente escuro sobre a imagem. 0% = transparente, 100% = totalmente preto.</p>
        <div class="gdc-ov-wrap">
            <div class="gdc-ov-layer" id="gdc-ov-layer"></div>
            <div class="gdc-ov-label">Prévia do sombreado</div>
        </div>
        <div class="gdc-box">
            <h3>Opacidade em cada ponto do gradiente</h3>
            <div class="gdc-slider-row">
                <label>Topo do card (0%)</label>
                <input type="range" min="0" max="100" name="gdc_overlay[op1]" id="gdc_ov_op1" value="<?php echo $ov['op1']; ?>">
                <span class="gdc-oval" id="gdc_ov_op1_lbl"><?php echo $ov['op1']; ?>%</span>
            </div>
            <div class="gdc-slider-row">
                <label>Meio superior (30%)</label>
                <input type="range" min="0" max="100" name="gdc_overlay[op2]" id="gdc_ov_op2" value="<?php echo $ov['op2']; ?>">
                <span class="gdc-oval" id="gdc_ov_op2_lbl"><?php echo $ov['op2']; ?>%</span>
            </div>
            <div class="gdc-slider-row">
                <label>Meio inferior (68%)</label>
                <input type="range" min="0" max="100" name="gdc_overlay[op3]" id="gdc_ov_op3" value="<?php echo $ov['op3']; ?>">
                <span class="gdc-oval" id="gdc_ov_op3_lbl"><?php echo $ov['op3']; ?>%</span>
            </div>
            <div class="gdc-slider-row">
                <label>Rodapé do card (100%)</label>
                <input type="range" min="0" max="100" name="gdc_overlay[op4]" id="gdc_ov_op4" value="<?php echo $ov['op4']; ?>">
                <span class="gdc-oval" id="gdc_ov_op4_lbl"><?php echo $ov['op4']; ?>%</span>
            </div>
        </div>
        <hr class="gdc-hr">
        <h2 class="title">Botão inferior</h2>
        <table class="form-table">
            <tr>
                <th><label for="gdc_more_url">URL do botão</label></th>
                <td><input type="url" id="gdc_more_url" name="gdc_more_url" class="regular-text" value="<?php echo esc_attr($more_url); ?>" placeholder="https://..."></td>
            </tr>
            <tr>
                <th><label for="gdc_more_text">Texto do botão</label></th>
                <td><input type="text" id="gdc_more_text" name="gdc_more_text" class="regular-text" value="<?php echo esc_attr($more_txt); ?>"></td>
            </tr>
        </table>
        <hr class="gdc-hr">
        <h2 class="title">📰 Posts automáticos</h2>
        <?php
        $auto_posts     = get_option('gdc_auto_posts','0');
        $auto_tag       = get_option('gdc_auto_tag','');
        $auto_count     = max(1,min(50,intval(get_option('gdc_auto_count','10'))));
        $auto_post_type = get_option('gdc_auto_post_type','post');
        /* listar post types públicos */
        $post_types = get_post_types(['public'=>true],'objects');
        /* listar tags/taxonomias do tipo selecionado */
        $taxonomies = get_object_taxonomies($auto_post_type,'objects');
        ?>
        <table class="form-table">
            <tr>
                <th>Usar posts automáticos</th>
                <td>
                    <label>
                        <input type="checkbox" name="gdc_auto_posts" value="1" <?php checked($auto_posts,'1'); ?>
                               onchange="document.getElementById('gdc-auto-opts').style.display=this.checked?'':'none'">
                        Buscar posts automaticamente (ignora a lista manual de cursos abaixo)
                    </label>
                </td>
            </tr>
        </table>
        <div id="gdc-auto-opts" style="<?php echo $auto_posts==='1'?'':'display:none'; ?>">
        <table class="form-table">
            <tr>
                <th><label for="gdc_auto_post_type">Tipo de post</label></th>
                <td>
                    <select name="gdc_auto_post_type" id="gdc_auto_post_type" class="regular-text"
                            onchange="this.form.submit()">
                        <?php foreach($post_types as $pt): ?>
                        <option value="<?php echo esc_attr($pt->name); ?>" <?php selected($auto_post_type,$pt->name); ?>>
                            <?php echo esc_html($pt->label); ?> (<?php echo $pt->name; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="description">Selecione o tipo de post e salve para atualizar as taxonomias disponíveis.</p>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_auto_tag">Filtrar por tag/categoria</label></th>
                <td>
                    <?php if(!empty($taxonomies)): ?>
                    <select name="gdc_auto_tag" id="gdc_auto_tag" class="regular-text">
                        <option value="">— Todos os posts —</option>
                        <?php foreach($taxonomies as $tax): ?>
                            <?php $terms=get_terms(['taxonomy'=>$tax->name,'hide_empty'=>true]); ?>
                            <?php if(!is_wp_error($terms)&&!empty($terms)): ?>
                            <optgroup label="<?php echo esc_attr($tax->label); ?>">
                            <?php foreach($terms as $term): ?>
                                <option value="<?php echo esc_attr($tax->name.':'.$term->slug); ?>"
                                        <?php selected($auto_tag,$tax->name.':'.$term->slug); ?>>
                                    <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                </option>
                            <?php endforeach; ?>
                            </optgroup>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <?php else: ?>
                    <p class="description">Nenhuma taxonomia encontrada para este tipo de post.</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_auto_count">Quantidade de posts</label></th>
                <td>
                    <input type="number" name="gdc_auto_count" id="gdc_auto_count" min="1" max="50"
                           value="<?php echo $auto_count; ?>" class="small-text"> posts
                </td>
            </tr>
            <tr>
                <th><label for="gdc_auto_badge">Badge padrão dos posts</label></th>
                <td>
                    <?php
                    $auto_badge        = get_option('gdc_auto_badge','');
                    $auto_badge_custom = get_option('gdc_auto_badge_custom','');
                    ?>
                    <select name="gdc_auto_badge" id="gdc_auto_badge" class="regular-text"
                            onchange="document.getElementById('gdc_badge_custom_wrap').style.display=this.value==='custom'?'':'none'">
                        <option value="" <?php selected($auto_badge,''); ?>>— Sem badge —</option>
                        <option value="grad" <?php selected($auto_badge,'grad'); ?>>Graduação</option>
                        <option value="pos"  <?php selected($auto_badge,'pos'); ?>>Pós-Graduação</option>
                        <option value="prof" <?php selected($auto_badge,'prof'); ?>>Profissionalizante</option>
                        <option value="tec"  <?php selected($auto_badge,'tec'); ?>>Técnico</option>
                        <option value="custom" <?php selected($auto_badge,'custom'); ?>>✏️ Personalizado</option>
                    </select>
                    <div id="gdc_badge_custom_wrap" style="margin-top:6px;<?php echo $auto_badge==='custom'?'':'display:none'; ?>">
                        <input type="text" name="gdc_auto_badge_custom"
                               value="<?php echo esc_attr($auto_badge_custom); ?>"
                               placeholder="Ex.: EXTENSÃO" class="regular-text">
                    </div>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_auto_modalidade">Modalidade padrão dos posts</label></th>
                <td>
                    <?php
                    $auto_modalidade   = get_option('gdc_auto_modalidade','');
                    $auto_modal_custom = get_option('gdc_auto_modal_custom','');
                    ?>
                    <select name="gdc_auto_modalidade" id="gdc_auto_modalidade" class="regular-text"
                            onchange="document.getElementById('gdc_modal_custom_wrap').style.display=this.value==='custom'?'':'none'">
                        <option value="" <?php selected($auto_modalidade,''); ?>>— Sem modalidade —</option>
                        <option value="ead" <?php selected($auto_modalidade,'ead'); ?>>EAD</option>
                        <option value="eadsemipresencial" <?php selected($auto_modalidade,'eadsemipresencial'); ?>>EAD Semipresencial</option>
                        <option value="presencial" <?php selected($auto_modalidade,'presencial'); ?>>Presencial</option>
                        <option value="custom" <?php selected($auto_modalidade,'custom'); ?>>✏️ Personalizado</option>
                    </select>
                    <div id="gdc_modal_custom_wrap" style="margin-top:6px;<?php echo $auto_modalidade==='custom'?'':'display:none'; ?>">
                        <input type="text" name="gdc_auto_modal_custom"
                               value="<?php echo esc_attr($auto_modal_custom); ?>"
                               placeholder="Ex.: HÍBRIDO" class="regular-text">
                    </div>
                </td>
            </tr>
            <tr>
                <th><label for="gdc_auto_saiba">Texto do botão "Saiba mais"</label></th>
                <td>
                    <?php
                    $auto_saiba  = get_option('gdc_auto_saiba','Saiba mais');
                    $show_saiba  = get_option('gdc_show_saiba','1');
                    ?>
                    <label style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                        <input type="checkbox" name="gdc_show_saiba" value="1" <?php checked($show_saiba,'1'); ?>>
                        Exibir botão "Saiba mais" nos cards
                    </label>
                    <input type="text" name="gdc_auto_saiba" id="gdc_auto_saiba"
                           value="<?php echo esc_attr($auto_saiba); ?>"
                           class="regular-text" placeholder="Saiba mais">
                    <p class="description">Texto do botão (quando exibido). Deixe vazio para usar "Saiba mais".</p>
                </td>
            </tr>
            <tr>
                <th>Mapeamento dos campos</th>
                <td>
                    <p class="description">
                        <strong>Título:</strong> título do post &nbsp;|&nbsp;
                        <strong>Imagem:</strong> imagem destacada &nbsp;|&nbsp;
                        <strong>URL:</strong> permalink do post &nbsp;|&nbsp;
                        <strong>Badge:</strong> definido na configuração de cores acima
                    </p>
                </td>
            </tr>
        </table>
        </div>

        <hr class="gdc-hr">
        <h2 class="title">Cursos</h2>
        <table class="widefat striped">
            <thead><tr>
                <th style="width:22%">Título</th><th style="width:24%">URL do curso</th>
                <th style="width:26%">URL da imagem</th><th style="width:12%">Badge</th>
                <th style="width:12%">Modalidade</th><th style="width:4%"></th>
            </tr></thead>
            <tbody id="gdc-rows">
            <?php
            $list=!empty($courses)?$courses:[['title'=>'','url'=>'','image'=>'','badge'=>'grad','modalidade'=>'']];
            foreach($list as $i=>$cv):
                $cv=is_array($cv)?$cv:[];
                $mod=strtolower($cv['modalidade']??'');
            ?>
            <tr>
                <td><input type="text" name="gdc_courses[<?php echo $i;?>][title]"  value="<?php echo esc_attr($cv['title']??''); ?>"  class="widefat" placeholder="Ex.: Direito"></td>
                <td><input type="url"  name="gdc_courses[<?php echo $i;?>][url]"    value="<?php echo esc_attr($cv['url']??''); ?>"    class="widefat" placeholder="https://..."></td>
                <td><input type="url"  name="gdc_courses[<?php echo $i;?>][image]"  value="<?php echo esc_attr($cv['image']??''); ?>"  class="widefat" placeholder="https://.../foto.webp"></td>
                <td>
                    <select name="gdc_courses[<?php echo $i;?>][badge]" class="widefat">
                        <option value="" <?php selected($cv['badge']??'grad','');?>>— Sem badge —</option>
                        <option value="grad" <?php selected($cv['badge']??'grad','grad');?>>Graduação</option>
                        <option value="pos"  <?php selected($cv['badge']??'','pos');?>>Pós-Graduação</option>
                        <option value="prof" <?php selected($cv['badge']??'','prof');?>>Profissionalizante</option>
                        <option value="tec"  <?php selected($cv['badge']??'','tec');?>>Técnico</option>
                    </select>
                </td>
                <td>
                    <select name="gdc_courses[<?php echo $i;?>][modalidade]" class="widefat">
                        <option value=""                  <?php selected($mod,'');?>>—</option>
                        <option value="ead"               <?php selected($mod,'ead');?>>EAD</option>
                        <option value="eadsemipresencial" <?php selected($mod,'eadsemipresencial');?>>EAD Semipresencial</option>
                        <option value="presencial"        <?php selected($mod,'presencial');?>>Presencial</option>
                    </select>
                </td>
                <td><button type="button" class="button gdc-rm">✕</button></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><button type="button" class="button" id="gdc-add">+ Adicionar curso</button></p>
        <?php submit_button('Salvar alterações'); ?>
    </form>
    </div>
    <script>
    (function(){
        var rows=document.getElementById('gdc-rows');
        document.getElementById('gdc-add').addEventListener('click',function(){
            var i=rows.querySelectorAll('tr').length;
            rows.insertAdjacentHTML('beforeend',
                '<tr>'
                +'<td><input type="text" name="gdc_courses['+i+'][title]" class="widefat" placeholder="Título"></td>'
                +'<td><input type="url" name="gdc_courses['+i+'][url]" class="widefat" placeholder="https://..."></td>'
                +'<td><input type="url" name="gdc_courses['+i+'][image]" class="widefat" placeholder="https://.../foto.webp"></td>'
                +'<td><select name="gdc_courses['+i+'][badge]" class="widefat"><option value="">— Sem badge —</option><option value="grad">Graduação</option><option value="pos">Pós-Graduação</option><option value="prof">Profissionalizante</option><option value="tec">Técnico</option></select></td>'
                +'<td><select name="gdc_courses['+i+'][modalidade]" class="widefat"><option value="" selected>—</option><option value="ead">EAD</option><option value="eadsemipresencial">EAD Semipresencial</option><option value="presencial">Presencial</option></select></td>'
                +'<td><button type="button" class="button gdc-rm">✕</button></td>'
                +'</tr>'
            );
        });
        rows.addEventListener('click',function(e){
            var t=e.target;
            if(t&&t.classList.contains('gdc-rm')){var tr=t.closest('tr');if(tr)tr.parentNode.removeChild(tr);}
        });
        var previewMap={
            'badge_grad':          {el:'gpv-grad',prop:'background'},
            'badge_pos':           {el:'gpv-pos', prop:'background'},
            'badge_prof':          {el:'gpv-prof',prop:'background'},
            'badge_tec':           {el:'gpv-tec', prop:'background'},
            'badge_ead_bg':        {el:'gpv-ead', prop:'background'},
            'badge_ead_txt':       {el:'gpv-ead', prop:'color'},
            'badge_eadsemi_bg':    {el:'gpv-semi',prop:'background'},
            'badge_eadsemi_txt':   {el:'gpv-semi',prop:'color'},
            'badge_presencial_bg': {el:'gpv-pres',prop:'background'},
            'badge_presencial_txt':{el:'gpv-pres',prop:'color'},
            'btn_bg':    [{el:'gpv-btn',prop:'background'},{el:'gpv-btn-preview',prop:'background'}],
            'btn_txt':   [{el:'gpv-btn',prop:'color'},{el:'gpv-btn-preview',prop:'color'}],
            'saiba_txt':       {el:'gpv-saiba-preview',      prop:'color'},
            'saiba_hover_bg':  {el:'gpv-saiba-hover-preview',prop:'color'},
            'arrow_bg':  [{el:'gpv-arrow-preview',prop:'background'},{el:'gpv-arrow-preview2',prop:'background'}],
            'arrow_txt': [{el:'gpv-arrow-preview',prop:'color'},{el:'gpv-arrow-preview2',prop:'color'}],
            'section_title':{el:'gpv-title',prop:'background'},
            'card_fallback_top':null,'card_fallback_bot':null,'card_dark_bg':null,
        };
        document.querySelectorAll('.gdc-swatch input[type=color]').forEach(function(ci){
            var key=ci.name.replace('gdc_colors[','').replace(']','');
            var hex=document.getElementById('gdc_hex_'+key);
            var sw=ci.parentElement;
            var pvm=previewMap[key];
            function apply(val){
                ci.value=val; if(hex)hex.value=val; sw.style.background=val;
                if(!pvm)return;
                var targets=Array.isArray(pvm)?pvm:[pvm];
                targets.forEach(function(p){ var el=document.getElementById(p.el); if(el)el.style[p.prop]=val; });
            }
            ci.addEventListener('input',function(){apply(ci.value);});
            if(hex){
                hex.addEventListener('input',function(){ var v=hex.value.trim(); if(/^#[0-9a-fA-F]{6}$/.test(v))apply(v); });
                hex.addEventListener('change',function(){ var v=hex.value.trim(); if(/^#[0-9a-fA-F]{6}$/.test(v))apply(v); else hex.value=ci.value; });
            }
        });
        var ovLayer=document.getElementById('gdc-ov-layer');
        function updateOverlay(){
            var o1=document.getElementById('gdc_ov_op1').value/100;
            var o2=document.getElementById('gdc_ov_op2').value/100;
            var o3=document.getElementById('gdc_ov_op3').value/100;
            var o4=document.getElementById('gdc_ov_op4').value/100;
            ovLayer.style.background='linear-gradient(180deg,rgba(0,0,0,'+o1.toFixed(2)+') 0%,rgba(0,0,0,'+o2.toFixed(2)+') 30%,rgba(0,0,0,'+o3.toFixed(2)+') 68%,rgba(0,0,0,'+o4.toFixed(2)+') 100%)';
        }
        ['op1','op2','op3','op4'].forEach(function(k){
            var sl=document.getElementById('gdc_ov_'+k);
            var lb=document.getElementById('gdc_ov_'+k+'_lbl');
            sl.addEventListener('input',function(){ lb.textContent=sl.value+'%'; updateOverlay(); });
        });
        updateOverlay();
    })();
    </script>
    <?php
}
function gdc_help_page(){
    if(!current_user_can('manage_options')) return; ?>
    <div class="wrap">
        <h1>Instruções — Grid de Cursos v2.5</h1>
        <p>Shortcode: <code>[grid_cursos]</code></p>
        <h3>Parâmetros opcionais</h3>
        <table class="widefat striped" style="max-width:560px">
            <thead><tr><th>Parâmetro</th><th>Padrão</th><th>Descrição</th></tr></thead>
            <tbody>
                <tr><td><code>count</code></td><td>20</td><td>Máximo de cursos exibidos</td></tr>
                <tr><td><code>title</code></td><td>Cursos em Destaque</td><td>Título da seção</td></tr>
                <tr><td><code>interval</code></td><td>5000</td><td>Autoplay em ms (0 = desligado)</td></tr>
            </tbody>
        </table>
    </div>
    <?php
}
/* ═══════════════════════════════════════════════════
   SHORTCODE — FRONT-END
═══════════════════════════════════════════════════ */
add_shortcode('grid_cursos','gdc_render');
function gdc_render($atts){
    $atts=shortcode_atts(['count'=>20,'title'=>'Cursos em Destaque','interval'=>5000],$atts);
    $auto_posts     = get_option('gdc_auto_posts','0');
    $auto_tag       = get_option('gdc_auto_tag','');
    $auto_count     = max(1,min(50,intval(get_option('gdc_auto_count','10'))));
    $auto_post_type = get_option('gdc_auto_post_type','post');
    $auto_badge        = get_option('gdc_auto_badge','');
    $auto_badge_custom = get_option('gdc_auto_badge_custom','');
    $auto_modalidade   = get_option('gdc_auto_modalidade','');
    $auto_modal_custom = get_option('gdc_auto_modal_custom','');
    /* se escolheu 'custom', usa o texto personalizado */
    if($auto_badge==='custom') $auto_badge='';
    if($auto_modalidade==='custom') $auto_modalidade='';
    $auto_saiba      = get_option('gdc_auto_saiba','Saiba mais');
    $show_saiba      = get_option('gdc_show_saiba','1');

    if($auto_posts==='1'){
        /* monta query */
        $query_args = [
            'post_type'      => $auto_post_type,
            'posts_per_page' => min($auto_count,(int)$atts['count']),
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];
        /* filtro por taxonomia:slug */
        if(!empty($auto_tag) && strpos($auto_tag,':')!==false){
            [$tax_name,$tax_slug] = explode(':',$auto_tag,2);
            $query_args['tax_query'] = [[
                'taxonomy' => $tax_name,
                'field'    => 'slug',
                'terms'    => $tax_slug,
            ]];
        }
        $wp_query = new WP_Query($query_args);
        $courses  = [];
        foreach($wp_query->posts as $p){
            $thumb = get_the_post_thumbnail_url($p->ID,'large') ?: '';
            $courses[] = [
                'title'      => $p->post_title,
                'url'        => get_permalink($p->ID),
                'image'      => $thumb,
                'badge'      => ($auto_badge==='custom'?'':$auto_badge),
                'badge_custom'=> $auto_badge_custom,
                'modalidade' => ($auto_modalidade==='custom'?'':$auto_modalidade),
                'modal_custom'=> $auto_modal_custom,
                'saiba'      => $auto_saiba,
            ];
        }
        wp_reset_postdata();
    } else {
        $courses = array_slice(get_option('gdc_courses',[]),0,(int)$atts['count']);
    }

    $more_url   = get_option('gdc_more_url','#');
    $more_txt   = get_option('gdc_more_text','Explorar outras graduações');
    $font_size  = get_option('gdc_font_size','16px');
    $colors     = wp_parse_args(get_option('gdc_colors',[]),gdc_color_defaults());
    $overlay    = wp_parse_args(get_option('gdc_overlay',[]),gdc_overlay_defaults());
    $gdc_titulo = get_option('gdc_titulo','');
    $gdc_pad     = wp_parse_args(get_option('gdc_padding',[]),['top'=>0,'bot'=>0]);
    $gdc_align   = wp_parse_args(get_option('gdc_align',[]),gdc_align_defaults());
    $gdc_weights     = wp_parse_args(get_option('gdc_weights',[]),gdc_weight_defaults());
    $fw              = array_map('intval',$gdc_weights);
    $saiba_bg_alpha  = max(0,min(100,intval(get_option('gdc_saiba_bg_alpha','8'))));
    $saiba_radius    = max(0,min(30,intval(get_option('gdc_saiba_radius','6'))));
    $arrow_radius    = max(0,min(30,intval(get_option('gdc_arrow_radius','6'))));
    $arrow_nobg      = get_option('gdc_arrow_nobg','0');
    $btn_radius      = max(0,min(30,intval(get_option('gdc_btn_radius','5'))));
    $badge_radius    = max(0,min(30,intval(get_option('gdc_badge_radius','6'))));
    $badgemod_radius = max(0,min(30,intval(get_option('gdc_badgemod_radius','4'))));
    /* converte hex para rgba com a opacidade configurada */
    $saiba_bg_hex   = $colors['saiba_bg'] ?? '#ffffff';
    $saiba_bg_r     = hexdec(substr(ltrim($saiba_bg_hex,'#'),0,2));
    $saiba_bg_g     = hexdec(substr(ltrim($saiba_bg_hex,'#'),2,2));
    $saiba_bg_b     = hexdec(substr(ltrim($saiba_bg_hex,'#'),4,2));
    $saiba_bg_rgba  = 'rgba('.$saiba_bg_r.','.$saiba_bg_g.','.$saiba_bg_b.','.number_format($saiba_bg_alpha/100,2).')';
    $hover_scale = get_option('gdc_hover_scale','0');
    $hover_esc   = get_option('gdc_hover_escurecer','1');
    $show_btn   = get_option('gdc_show_btn','1');
    $fonts      = wp_parse_args(get_option('gdc_fonts',[]),gdc_font_defaults());
    $fs         = array_map('intval',$fonts);
    $total      = count($courses);
    if($total===0) return '<!-- grid_cursos: nenhum curso cadastrado -->';
    $is_carousel     = ($total>=6);
    $mobile_carousel = ($total>=5); // no mobile, carrossel ativa com 5+ cards
    $uid         = 'gdc'.substr(md5(uniqid()),0,8);
    $interval    = max(0,(int)$atts['interval']);
    $c           = array_map('esc_attr',$colors);
    $ov1 = number_format(intval($overlay['op1'])/100,2,'.','');
    $ov2 = number_format(intval($overlay['op2'])/100,2,'.','');
    $ov3 = number_format(intval($overlay['op3'])/100,2,'.','');
    $ov4 = number_format(intval($overlay['op4'])/100,2,'.','');
    $badge_map=[
        ''    =>['txt'=>'',                  'cls'=>''],
        'grad'=>['txt'=>'GRADUAÇÃO',         'cls'=>'is-grad'],
        'pos' =>['txt'=>'PÓS-GRADUAÇÃO',    'cls'=>'is-pos'],
        'prof'=>['txt'=>'PROFISSIONALIZANTE','cls'=>'is-prof'],
        'tec' =>['txt'=>'TÉCNICO',           'cls'=>'is-tec'],
    ];
    $mod_map=[
        'ead'               =>['txt'=>'EAD',              'cls'=>'is-ead'],
        'eadsemipresencial' =>['txt'=>'EAD/SEMIPRESENCIAL','cls'=>'is-eadsemi'],
        'presencial'        =>['txt'=>'PRESENCIAL',        'cls'=>'is-presencial'],
    ];
    ob_start();
    foreach($courses as $course){
        $title   = esc_html($course['title']??'');
        $url     = esc_url($course['url']??'#');
        $img     = esc_url($course['image']??'');
        $bk      = $course['badge']??'';
        $b       = $badge_map[$bk]??$badge_map[''];
        if(!empty($course['badge_custom']??'')) $b=['txt'=>esc_html($course['badge_custom']),'cls'=>'is-grad'];
        $mk       = strtolower(trim($course['modalidade']??''));
        $m        = $mod_map[$mk]??null;
        if(!empty($course['modal_custom']??'')) $m=['txt'=>esc_html($course['modal_custom']),'cls'=>'is-ead'];
        $saiba_label = esc_html($course['saiba']??'Saiba mais');
        $has_img = !empty($img);
        ?>
        <article class="gdc-card<?php echo !$has_img?' gdc-no-img':''; ?>" onclick="window.location.href='<?php echo $url; ?>'" style="cursor:pointer">
            <?php if($has_img): ?>
            <img class="gdc-img" src="<?php echo $img; ?>" alt="<?php echo $title; ?>" loading="lazy"
                 onerror="this.style.display='none';this.closest('.gdc-card').classList.add('gdc-no-img')">
            <?php endif; ?>
            <div class="gdc-overlay"></div>
            <?php if(!empty($b['txt'])||$m): ?>
            <div class="gdc-badges">
                <?php if(!empty($b['txt'])): ?>
                <span class="gdc-badge <?php echo $b['cls']; ?>"><?php echo $b['txt']; ?></span>
                <?php endif; ?>
                <?php if($m): ?>
                <span class="gdc-badge-mod <?php echo $m['cls']; ?>"><?php echo esc_html($m['txt']); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if($show_saiba==='1'): ?>
            <div class="gdc-cta"><a href="<?php echo $url; ?>"><?php echo $saiba_label; ?></a></div>
            <?php endif; ?>
            <div class="gdc-name"><?php echo $title; ?></div>
        </article>
        <?php
    }
    $cards_html=ob_get_clean();
    ob_start();
    ?>
<!-- PLUGIN: Grid de Cursos v2.5 | [grid_cursos] -->
<section id="<?php echo $uid; ?>" class="gdc-section">
<style>
#<?php echo $uid; ?>,#<?php echo $uid; ?> *,#<?php echo $uid; ?> *::before,#<?php echo $uid; ?> *::after{box-sizing:border-box}
#<?php echo $uid; ?> a{text-decoration:none}
#<?php echo $uid; ?> img{display:block;border:none}
#<?php echo $uid; ?> h2,#<?php echo $uid; ?> p,#<?php echo $uid; ?> span,#<?php echo $uid; ?> div{margin:0;padding:0}
#<?php echo $uid; ?>.gdc-section{
    font-size:<?php echo esc_attr($font_size);?>;
    font-family:"Poppins",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
    padding:<?php echo intval($gdc_pad['top']);?>px 0 <?php echo intval($gdc_pad['bot']);?>px!important;
    margin:0!important;color:#0f172a;
    background:transparent!important;
    background-color:transparent!important;
}
#<?php echo $uid; ?> .gdc-wrap,
#<?php echo $uid; ?> .gdc-carousel-wrap,
#<?php echo $uid; ?> .gdc-view,
#<?php echo $uid; ?> .gdc-track,
#<?php echo $uid; ?> .gdc-grid{
    background:transparent!important;
    background-color:transparent!important;
}
#<?php echo $uid; ?> .gdc-wrap{max-width:1120px;margin:0 auto!important;padding:0!important}
#<?php echo $uid; ?> .gdc-titulo{
    font-family:"Poppins",system-ui,Arial,sans-serif;
    font-weight:<?php echo $fw['titulo'];?>;
    font-size:<?php echo $fs['titulo'];?>px;
    line-height:1.3;
    color:<?php echo $c['section_title'];?>;
    margin:0 0 16px!important;
    padding:0!important;
    display:block;
}
#<?php echo $uid; ?> .gdc-grid{display:grid;gap:14px;grid-template-columns:repeat(2,1fr)}
@media(min-width:600px){#<?php echo $uid; ?> .gdc-grid{grid-template-columns:repeat(3,1fr)}}
@media(min-width:992px){#<?php echo $uid; ?> .gdc-grid{grid-template-columns:repeat(5,1fr)}}
/* Carrossel só mobile (5 cards): esconde carrossel no desktop, mostra grid */
@media(min-width:769px){
    #<?php echo $uid; ?> .gdc-mobile-only-carousel{display:none!important;}
}
/* Grid só desktop (5 cards): esconde grid no mobile */
@media(max-width:768px){
    #<?php echo $uid; ?> .gdc-desktop-only-grid{display:none!important;}
}
#<?php echo $uid; ?> .gdc-card{
    position:relative;border-radius:12px;overflow:hidden;height:400px;
    background:<?php echo $c['card_dark_bg'];?>;
    box-shadow:0 8px 20px rgba(2,6,23,.14);
    transition:box-shadow .35s ease;flex-shrink:0;
}
<?php if($hover_esc==='1'): ?>
#<?php echo $uid; ?> .gdc-track:has(.gdc-card:hover) .gdc-card,
#<?php echo $uid; ?> .gdc-grid:has(.gdc-card:hover) .gdc-card{
    filter:brightness(.5) saturate(.7);
    transition:filter .35s ease, box-shadow .35s ease;
}
#<?php echo $uid; ?> .gdc-track:has(.gdc-card:hover) .gdc-card:hover,
#<?php echo $uid; ?> .gdc-grid:has(.gdc-card:hover) .gdc-card:hover{
    filter:none;
    box-shadow:0 18px 38px rgba(2,6,23,.28);
    z-index:3;
}
<?php endif; ?>
<?php if($hover_scale==='1'): ?>
/* destaque hover: expande o card levemente — apenas desktop */
@media(min-width:601px){
    #<?php echo $uid; ?> .gdc-card{
        transition:box-shadow .35s ease, transform .35s ease;
    }
    #<?php echo $uid; ?> .gdc-card:hover{
        transform:scale(1.04);
        box-shadow:0 18px 38px rgba(2,6,23,.30);
        z-index:3;
    }
}
<?php endif; ?>
#<?php echo $uid; ?> .gdc-img{position:absolute;inset:0;width:100%;height:100%;max-width:none;object-fit:cover;object-position:center;display:block;filter:saturate(.95);transition:filter .35s ease;}
#<?php echo $uid; ?> .gdc-card.gdc-no-img{background:linear-gradient(145deg,<?php echo $c['card_fallback_top'];?> 0%,<?php echo $c['card_fallback_bot'];?> 100%)}
#<?php echo $uid; ?> .gdc-overlay{
    position:absolute;inset:0;z-index:1;pointer-events:none;
    background:linear-gradient(180deg,
        rgba(0,0,0,<?php echo $ov1;?>) 0%,
        rgba(0,0,0,<?php echo $ov2;?>) 30%,
        rgba(0,0,0,<?php echo $ov3;?>) 68%,
        rgba(0,0,0,<?php echo $ov4;?>) 100%
    );
}
#<?php echo $uid; ?> .gdc-badges{
    position:absolute;top:12px;
    <?php if($gdc_align['badge']==='left'): ?>left:12px;<?php elseif($gdc_align['badge']==='right'): ?>right:12px;<?php else: ?>left:50%;transform:translateX(-50%);<?php endif; ?>
    z-index:2;display:flex;flex-direction:column;
    <?php if($gdc_align['badge']==='left'): ?>align-items:flex-start;<?php elseif($gdc_align['badge']==='right'): ?>align-items:flex-end;<?php else: ?>align-items:stretch;<?php endif; ?>
    gap:5px;width:max-content;max-width:calc(100% - 24px);
}
#<?php echo $uid; ?> .gdc-badge{
    display:block;color:#fff;/* sobrescrito por classe abaixo */
    font-family:"Poppins",system-ui,Arial,sans-serif;font-weight:<?php echo $fw['badge'];?>;font-size:<?php echo $fs['badge'];?>px;
    text-transform:uppercase;letter-spacing:.4px;line-height:1.3;text-align:center;
    padding:6px 16px;border-radius:<?php echo $badge_radius;?>px;white-space:nowrap;
    box-shadow:0 2px 6px rgba(0,0,0,.25);
}
@media(max-width:480px){
    #<?php echo $uid; ?> .gdc-badge{font-size:<?php echo max(6,intval($fs['badge']*0.82));?>px;letter-spacing:.2px;padding:5px 10px;white-space:normal;word-break:break-word;}
    #<?php echo $uid; ?> .gdc-badge-mod{font-size:<?php echo max(6,intval($fs['badge_mod']*0.8));?>px;padding:4px 10px;white-space:normal;word-break:break-word;}
    #<?php echo $uid; ?> .gdc-badges{max-width:calc(100% - 12px)}
}
#<?php echo $uid; ?> .gdc-badge.is-grad{background:<?php echo $c['badge_grad'];?>;color:<?php echo $c['badge_grad_txt'];?>}
#<?php echo $uid; ?> .gdc-badge.is-pos {background:<?php echo $c['badge_pos'];?>;color:<?php echo $c['badge_pos_txt'];?>}
#<?php echo $uid; ?> .gdc-badge.is-prof{background:<?php echo $c['badge_prof'];?>;color:<?php echo $c['badge_prof_txt'];?>}
#<?php echo $uid; ?> .gdc-badge.is-tec {background:<?php echo $c['badge_tec'];?>;color:<?php echo $c['badge_tec_txt'];?>}
#<?php echo $uid; ?> .gdc-badge-mod{
    display:block;
    font-family:"Poppins",system-ui,Arial,sans-serif;font-weight:<?php echo $fw['badge_mod'];?>;font-size:<?php echo $fs['badge_mod'];?>px;
    text-transform:uppercase;letter-spacing:.3px;line-height:1.3;text-align:center;
    padding:5px 16px;border-radius:<?php echo $badgemod_radius;?>px;white-space:nowrap;
    box-shadow:0 1px 4px rgba(0,0,0,.15);
}
#<?php echo $uid; ?> .gdc-badge-mod.is-ead      {background:<?php echo $c['badge_ead_bg'];?>;       color:<?php echo $c['badge_ead_txt'];?>}
#<?php echo $uid; ?> .gdc-badge-mod.is-eadsemi  {background:<?php echo $c['badge_eadsemi_bg'];?>;   color:<?php echo $c['badge_eadsemi_txt'];?>}
#<?php echo $uid; ?> .gdc-badge-mod.is-presencial{background:<?php echo $c['badge_presencial_bg'];?>;color:<?php echo $c['badge_presencial_txt'];?>}
#<?php echo $uid; ?> .gdc-cta{
    position:absolute;
    top:<?php echo $fs['saiba_pos'];?>%;
    <?php if($gdc_align['saiba']==='left'): ?>left:12px;transform:translateY(-50%);<?php elseif($gdc_align['saiba']==='right'): ?>right:12px;transform:translateY(-50%);<?php else: ?>left:50%;transform:translate(-50%,-50%);<?php endif; ?>
    z-index:2;display:flex;justify-content:center;align-items:center;
}
#<?php echo $uid; ?> .gdc-cta a{
    display:inline-block;padding:7px 20px;
    border:2px solid <?php echo $c['saiba_border'];?>;border-radius:<?php echo $saiba_radius;?>px;
    color:<?php echo $c['saiba_txt'];?>;
    font-family:"Poppins",system-ui,Arial,sans-serif;
    font-weight:<?php echo $fw['saiba'];?>;font-size:<?php echo $fs['saiba'];?>px;line-height:1.2;white-space:nowrap;
    background:<?php echo $saiba_bg_rgba; ?>;
    transition:background .22s ease,border-color .22s ease,color .22s ease;
}
#<?php echo $uid; ?> .gdc-cta a:hover{background:rgba(255,255,255,.92);border-color:<?php echo $c['saiba_border'];?>;color:<?php echo $c['saiba_hover_bg'];?>}
#<?php echo $uid; ?> .gdc-name{
    position:absolute;left:12px;right:12px;bottom:18px;z-index:2;
    color:<?php echo $c['card_title_txt'];?>;font-family:"Poppins",system-ui,Arial,sans-serif;
    font-weight:<?php echo $fw['nome'];?>;font-size:<?php echo $fs['nome'];?>px;line-height:1.3;
    text-shadow:0 2px 10px rgba(0,0,0,.70);
    text-align:<?php echo esc_attr($gdc_align['nome']); ?>;
}
#<?php echo $uid; ?> .gdc-carousel-wrap{position:relative;padding:0 48px;}
<?php if($hover_scale==='1'): ?>
/* scale: view-outer corta X, padding vertical abre espaço pro scale em Y */
#<?php echo $uid; ?> .gdc-view-outer{
    overflow:hidden;
    padding:8px 0;
    margin:-8px 0;
    clip-path:inset(-8px 0px);
}
#<?php echo $uid; ?> .gdc-view{overflow:hidden;padding:0;margin:0;}
<?php else: ?>
#<?php echo $uid; ?> .gdc-view-outer{overflow:hidden;}
#<?php echo $uid; ?> .gdc-view{overflow:hidden;padding:0;margin:0;}
<?php endif; ?>
#<?php echo $uid; ?> .gdc-track{display:flex;gap:14px;transition:transform .35s ease;will-change:transform}
#<?php echo $uid; ?> .gdc-arrow{
    position:absolute;top:50%;transform:translateY(-50%);z-index:10;
    width:40px;height:56px;
    border-radius:<?php echo $arrow_radius;?>px;border:none;
    background:<?php echo $arrow_nobg==='1'?'transparent':$c['arrow_bg'];?>;
    color:<?php echo $c['arrow_txt'];?>;
    font-size:<?php echo $fs['seta'];?>px;font-weight:700;line-height:1;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    transition:filter .2s ease,transform .2s ease;padding:0;
    box-shadow:<?php echo $arrow_nobg==='1'?'none':'0 4px 14px rgba(0,0,0,.30)';?>;
}
#<?php echo $uid; ?> .gdc-arrow:hover{filter:brightness(1.15);transform:translateY(-50%) scaleY(1.04)}
#<?php echo $uid; ?> .gdc-arrow:disabled{opacity:.35;cursor:default;filter:none;transform:translateY(-50%)}
#<?php echo $uid; ?> .gdc-arrow.prev{left:0}
#<?php echo $uid; ?> .gdc-arrow.next{right:0}
@media(max-width:600px){
    #<?php echo $uid; ?> .gdc-carousel-wrap{padding:0}
    #<?php echo $uid; ?> .gdc-arrow{display:none}
}
#<?php echo $uid; ?> .gdc-bottom{text-align:center;margin:16px 0 0!important;padding:0!important}
#<?php echo $uid; ?> .gdc-bottom a{
    display:inline-block;margin:0!important;
    background:<?php echo $c['btn_bg'];?>;color:<?php echo $c['btn_txt'];?>;
    font-family:"Poppins",system-ui,Arial,sans-serif;
    font-weight:<?php echo $fw['btn'];?>;font-size:<?php echo $fs['btn'];?>px;letter-spacing:.2px;
    padding:10px 20px;border-radius:<?php echo $btn_radius;?>px;border:1px solid rgba(255,255,255,.20);
    box-shadow:0 8px 20px rgba(15,75,215,.25);
    transition:transform .15s ease,box-shadow .15s ease,filter .15s ease;
}
#<?php echo $uid; ?> .gdc-bottom a:hover{transform:translateY(-1px);filter:brightness(1.08)}
#<?php echo $uid; ?> .gdc-bottom a:active{transform:translateY(0);filter:brightness(.98)}
</style>
<div class="gdc-wrap">
    <?php if(!empty($gdc_titulo)): ?>
    <div class="gdc-titulo"><?php echo esc_html($gdc_titulo); ?></div>
    <?php endif; ?>
    <?php if($is_carousel): ?>
    <div class="gdc-carousel-wrap">
        <button class="gdc-arrow prev" aria-label="Anterior">&#8249;</button>
        <div class="gdc-view-outer"><div class="gdc-view"><div class="gdc-track"><?php echo $cards_html; ?></div></div></div>
        <button class="gdc-arrow next" aria-label="Próximo">&#8250;</button>
    </div>
    <?php elseif($mobile_carousel): ?>
    <div class="gdc-carousel-wrap gdc-mobile-only-carousel">
        <button class="gdc-arrow prev" aria-label="Anterior">&#8249;</button>
        <div class="gdc-view-outer"><div class="gdc-view"><div class="gdc-track"><?php echo $cards_html; ?></div></div></div>
        <button class="gdc-arrow next" aria-label="Próximo">&#8250;</button>
    </div>
    <div class="gdc-grid gdc-desktop-only-grid"><?php echo $cards_html; ?></div>
    <?php else: ?>
    <div class="gdc-grid"><?php echo $cards_html; ?></div>
    <?php endif; ?>
    <?php if($show_btn==='1'&&!empty($more_url)&&$more_url!=='#'): ?>
    <div class="gdc-bottom"><a href="<?php echo esc_url($more_url); ?>"><?php echo esc_html($more_txt); ?></a></div>
    <?php endif; ?>
</div>
</section>
<?php if($is_carousel||$mobile_carousel): ?>
<script>
(function(){
    var section=document.getElementById('<?php echo $uid; ?>');
    if(!section)return;
    /* Se for carrossel apenas mobile (5 cards), busca o wrap mobile */
    var mobileOnly=<?php echo $mobile_carousel&&!$is_carousel?'true':'false'; ?>;
    var carouselWrap=mobileOnly?section.querySelector('.gdc-mobile-only-carousel'):section.querySelector('.gdc-carousel-wrap');
    if(!carouselWrap)return;
    var view=carouselWrap.querySelector('.gdc-view');
    var track=carouselWrap.querySelector('.gdc-track');
    var prev=carouselWrap.querySelector('.gdc-arrow.prev');
    var next=carouselWrap.querySelector('.gdc-arrow.next');
    if(!view||!track)return;
    function fixBg(el){
        if(!el)return;
        el.style.setProperty('background','transparent','important');
        el.style.setProperty('background-color','transparent','important');
    }
    fixBg(carouselWrap);
    fixBg(carouselWrap.querySelector('.gdc-view-outer'));
    fixBg(view);
    fixBg(track);
    var cards=Array.prototype.slice.call(track.children);
    var n=cards.length,idx=0,timer=null,GAP=14,INT=<?php echo $interval; ?>;
    function spv(){var w=view.offsetWidth;if(w<=480)return 2;if(w<=768)return 3;return 5;}
    function calcBw(){var s=spv();return Math.floor((view.offsetWidth-GAP*(s-1))/s);}
    function applyWidths(){var bw=calcBw();cards.forEach(function(c){c.style.width=bw+'px';c.style.flexBasis=bw+'px';});return bw;}
    function maxI(){return Math.max(0,n-spv());}
    function render(i,anim){if(typeof anim==='undefined')anim=true;i=Math.max(0,Math.min(i,maxI()));idx=i;var bw=applyWidths();track.style.transition=anim?'transform .35s ease':'none';track.style.transform='translateX(-'+(idx*(bw+GAP))+'px)';if(prev)prev.disabled=(idx===0);if(next)next.disabled=(idx>=maxI());}
    function startAuto(){if(!INT)return;stopAuto();timer=setInterval(function(){render(idx>=maxI()?0:idx+1);},INT);}
    function stopAuto(){if(timer){clearInterval(timer);timer=null;}}
    if(prev)prev.addEventListener('click',function(){stopAuto();render(idx-1);startAuto();});
    if(next)next.addEventListener('click',function(){stopAuto();render(idx+1);startAuto();});
    section.addEventListener('mouseenter',stopAuto);
    section.addEventListener('mouseleave',startAuto);

    /* ── SWIPE TOUCH MOBILE ── */
    var tsX=0,tsY=0,dragging=false;
    view.addEventListener('touchstart',function(e){
        tsX=e.touches[0].clientX;
        tsY=e.touches[0].clientY;
        dragging=true;
        stopAuto();
    },{passive:true});
    view.addEventListener('touchmove',function(e){
        if(!dragging)return;
        var dx=tsX-e.touches[0].clientX;
        var dy=tsY-e.touches[0].clientY;
        /* só swipe horizontal — ignora scroll vertical */
        if(Math.abs(dx)>Math.abs(dy)) e.preventDefault();
    },{passive:false});
    view.addEventListener('touchend',function(e){
        if(!dragging)return;
        dragging=false;
        var dx=tsX-e.changedTouches[0].clientX;
        var threshold=40;
        if(dx>threshold) render(idx+1);
        else if(dx<-threshold) render(idx-1);
        startAuto();
    },{passive:true});
    var initialized=false;
    function isMobileView(){return window.innerWidth<=768;}
    function init(){
        if(mobileOnly&&!isMobileView())return; /* não inicializa no desktop */
        if(view.offsetWidth>0&&!initialized){initialized=true;render(0,false);startAuto();}
    }
    if(window.ResizeObserver){var ro=new ResizeObserver(function(){if(!initialized){init();}else{render(idx,false);}});ro.observe(view);}
    else{var rTO;window.addEventListener('resize',function(){clearTimeout(rTO);rTO=setTimeout(function(){render(idx,false);},80);});var attempts=0;var check=setInterval(function(){attempts++;if(view.offsetWidth>0||attempts>20){clearInterval(check);init();}},50);}
    init();
})();
</script>
<?php endif; ?>
    <?php
    return ob_get_clean();
}
