<?php

/**
 * Adds shortcodes.
 */
class SJKOne_Shortcodes {

	// CSS variables
	const cl_spotify_sc = 'sjk-1-spotify-sc';
	const cl_spotify_flex = 'sjk-1-spotify-flex';
	const cl_spotify_item = 'sjk-1-spotify-item';

	/**
	 * Add the shortcode.
	 */
	static function add_shortcodes(): void {
		add_shortcode( 'sjk_spotify_flex', [ __CLASS__, 'render_spotify_flex' ] );
	}


	/**
	 * Return an array of Spotify embeds. Each one should have:
	 * link; type; date of release; and whether to hide it.
	 * @return array
	 */
	private static function get_spotify_embeds(): array {
		$datas = [];

		$ps = get_posts(["numberposts" => -1, "post_type" => "spotify-embed"]);
		foreach ($ps as $p) {
			$data = [];

			$data["link"] = get_field("embed_link", $p->ID);
			$data["type"] = get_field("type", $p->ID);
			$data["date"] = get_field("release_date", $p->ID);
			$data["hide"] = get_field("hide", $p->ID);

			$datas[] = $data
;		}

		return $datas;
	}

	static function render_spotify_iframe(string $url): string {
		// normal https://open.spotify.com/album/11e9Ymoa490gMlOegDneT3
		// embed  https://open.spotify.com/embed/album/11e9Ymoa490gMlOegDneT3?utm_source=oembed

		// so hackish
		if (strpos($url, "track")) {
			$prefix = "track";
		} else {
			$prefix = "album";
		}

		$url = trim($url, "/");
		$parts = explode("/", $url);
		$id = end($parts);

		$src = "https://open.spotify.com/embed/{$prefix}/{$id}?utm_source=oembed";
		return "<iframe style='border-radius: 12px' width='100%' height='352' frameborder='0' allowfullscreen allow='autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture' loading='lazy' src='{$src}'></iframe>";
	}

	/**
	 * Return the html for a Spotify embed. It should have:
	 *  link; type; date of release; and whether to hide it.
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	static function render_spotify_embed( array $data ): string {
//		$link = $data["link"];
//		$type = $data["type"];
//		$date = $data["date"];
//		$hide = $data["hide"];
//		return "{$link} / {$type} / {$date} / {$hide}";

//		$encoded = urlencode($data["link"]);
//		$api_url = "https://open.spotify.com/oembed?url={$encoded}";
//		$resp = json_decode(file_get_contents($api_url));
//		return $resp["html"];

		return self::render_spotify_iframe($data["link"]);
	}

	/**
	 * Render the Spotify embeds grid.
	 *
	 * @param string $atts The shortcode attributes. Unused.
	 *
	 * @return string
	 */
	static function render_spotify_flex( string $atts ): string {

		$embeds = self::get_spotify_embeds();
		$embeds = array_filter($embeds, function(array $data): bool {
			return ! $data["hide"];
		});

		if ( empty( $embeds ) ) {
			return "";
		}

		usort($embeds, function(array $a, array $b): int {
			// Latest first
			return $b["date"] <=> $a["date"];
		});

		$albums = array_filter($embeds, function(array $data): bool {
			return $data["type"] == "album";
		});
		$html_albums = JKNLayouts::flex($albums, [__CLASS__, 'render_spotify_embed'],
			self::cl_spotify_flex, self::cl_spotify_item );
		$html_albums = "<h2>Albums & EPs</h2>" . $html_albums;

		$singles = array_filter($embeds, function(array $data): bool {
			return $data["type"] == "single";
		});
		$html_singles = JKNLayouts::flex($singles, [__CLASS__, 'render_spotify_embed'],
			self::cl_spotify_flex, self::cl_spotify_item );
		$html_singles = "<h2>Singles</h2>" . $html_singles;

		$html = "<div class='" . self::cl_spotify_sc . "'>{$html_albums}{$html_singles}</div>";

		return self::css_spotify() . $html;
	}

	/**
	 * Insert the formatted CSS directly.
	 */
	static function css_spotify(): string {

		$cl_sc = self::cl_spotify_sc;
		$cl_flex = self::cl_spotify_flex;
		$cl_item = self::cl_spotify_item;

		return JKNCSS::tag( "
            /* Spotify Flex */
            
            .{$cl_sc} {
                display: flex;
                flex-direction: column;
                justify-content: start;
                gap: 25px;
            }

            .{$cl_flex} {
			    gap: 50px;
			}
			
			.{$cl_item} {
			    width: 500px;
			}
        ");
	}
}
