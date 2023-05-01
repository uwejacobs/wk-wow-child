<?php
    echo '<style>.owmw-main-symbol.owmw-symbol-svg { margin-top: -30px; }</style>';
    echo '<table id="owmw-custom-navbar"><tbody><tr>';
    echo '<td class="owmw-custom-date">' . esc_html($owmw_data["today_day"]) . '</td>';
    echo '<td class="owmw-custom-symbol">' .  wp_kses($owmw_html["now"]["symbol"], $owmw_opt['allowed_html']) . '</td>';
    echo '<td class="owmw-custom-temperature">' . esc_html($owmw_data["temperature"] . $owmw_data["temperature_unit_character"]) . '</td>';
    echo '<td class="owmw-custom-location">' . esc_html($owmw_data["name"]) . '</td>';
    echo '</tr></tbody></table>';
