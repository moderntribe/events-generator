<?php
namespace Tribe\CLI\Payouts;


/**
 * Class Command
 *
 * @since TBD
 */
class Command extends \WP_CLI_Command {

	/**
	 * @var Generator\CLI
	 */
	protected $payout_generator;

	/**
	 * Command constructor.
	 *
	 * @since TBD
	 *
	 * @param Generator $payout_generator
	 */
	public function __construct( Generator\CLI $payout_generator ) {
		parent::__construct();
		$this->payout_generator = $payout_generator;

		/** @var \Tribe__Events__Community__Tickets__Main $main */
		$main = \Tribe__Events__Community__Tickets__Main::instance();

		$main->bootstrap();

		// always use sandbox
		$main->set_option( 'paypal_sandbox', 1 );
	}

	/**
	 * Generates PayPal orders and Payouts for one or more tickets.
	 *
	 * ## OPTIONS
	 *
	 * <ticket_id>
	 * : PayPal orders will be attached to this ticket(s); either a ticket post ID or a CSV list of ticket post IDs
	 *
	 * [--count=<count>]
	 * : the number of Payouts to generate
	 * ---
	 * default: 10
	 * ---
	 *
	 * [--status=<status>]
	 * : the status of the Payouts  - order status will be matched to this
	 * ---
	 * default: pending
	 * options:
	 *      - pending
	 *      - paid
	 *      - failed
	 * ---
	 *
	 * [--ticket_id=<ticket_id>]
	 * : the ID of the ticket payouts/orders should be assigned to
	 *
	 *
	 * ## EXAMPLES
	 *
	 *      wp tribe payouts generate-payouts 23
	 *      wp tribe payouts generate-payouts 23,89
	 *      wp tribe payouts generate-payouts 23,89,31
	 *      wp tribe payouts generate-payouts 23 ---count=5
	 *      wp tribe payouts generate-payouts 23,31 ---count=5
	 *      wp tribe payouts generate-payouts 23 --ticket_id=89
	 *      wp tribe payouts generate-payouts 23  --count=5 --ticket_id=89
	 *      wp tribe payouts generate-payouts 23 --count=5 --ticket_id=89 --status=pending
	 *
	 * @subcommand generate-payouts
	 *
	 * @since TBD
	 *
	 */
	public function generate_payouts( array $args = null, array $assoc_args = null ) {
		$this->payout_generator->generate_payouts( $args, $assoc_args );
	}

	/**
	 * Removes generated Payouts for a specific ticket or ticketed post.
	 *
	 * ## OPTIONS
	 *
	 * <post_id>
	 * : PayPal orders will be removed from this post or for this ticket ID
	 *
	 * ## EXAMPLES
	 *
	 *      wp tribe payouts reset-payouts 23
	 *
	 * @subcommand reset-payouts
	 *
	 * @since TBD
	 *
	 */
	public function reset_payouts( array $args = null, array $assoc_args = null ) {
		$this->payout_generator->reset_payouts( $args, $assoc_args );
	}
}