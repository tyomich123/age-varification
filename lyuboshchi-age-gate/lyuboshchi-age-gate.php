<?php
/**
 * Plugin Name: Lyuboshchi Age Verification Popunder
 * Description: Додає popunder 18+ для магазину з cookie на 30 днів.
 * Version: 1.0.0
 * Author: Custom
 * Text Domain: lyuboshchi-age-gate
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Lyuboshchi_Age_Gate {
    private const COOKIE_NAME = 'lyuboshchi_age_verified';

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_footer', [$this, 'render_modal']);
    }

    public function enqueue_assets(): void {
        if (is_admin()) {
            return;
        }

        $version = '1.0.0';
        $base_url = plugin_dir_url(__FILE__);

        wp_enqueue_style(
            'lyuboshchi-age-gate',
            $base_url . 'assets/css/age-gate.css',
            [],
            $version
        );

        wp_enqueue_script(
            'lyuboshchi-age-gate',
            $base_url . 'assets/js/age-gate.js',
            [],
            $version,
            true
        );

        wp_localize_script('lyuboshchi-age-gate', 'LyuboshchiAgeGate', [
            'cookieName' => self::COOKIE_NAME,
            'cookieDays' => 30,
            'redirectUrl' => 'https://www.google.com/',
        ]);
    }

    public function render_modal(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <div id="lyuboshchi-age-gate" class="lyuboshchi-age-gate" aria-hidden="true">
            <div class="lyuboshchi-age-gate__overlay"></div>
            <div class="lyuboshchi-age-gate__modal" role="dialog" aria-modal="true" aria-labelledby="lyuboshchi-age-gate-title">
                <div class="lyuboshchi-age-gate__brand">❤ LYUBOSHCHI</div>
                <h2 id="lyuboshchi-age-gate-title" class="lyuboshchi-age-gate__title">Підтвердження віку 18+</h2>
                <p class="lyuboshchi-age-gate__text">
                    Цей сайт містить товари для дорослих. Будь ласка, підтвердіть, що вам вже виповнилося 18 років.
                </p>

                <div class="lyuboshchi-age-gate__actions">
                    <button type="button" class="lyuboshchi-age-gate__btn lyuboshchi-age-gate__btn--yes" data-age-action="yes">
                        Так, мені є 18
                    </button>
                    <button type="button" class="lyuboshchi-age-gate__btn lyuboshchi-age-gate__btn--no" data-age-action="no">
                        Ні
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
}

new Lyuboshchi_Age_Gate();
