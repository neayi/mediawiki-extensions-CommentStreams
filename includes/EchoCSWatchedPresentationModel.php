<?php
/*
 * Copyright (c) 2016 The MITRE Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

class EchoCSWatchedPresentationModel extends EchoEventPresentationModel {

	/**
	 * @return string The symbolic icon name as defined in $wgEchoNotificationIcons
	 */
	public function getIconType() {
		return 'chat';
	}

	/**
	 * Array of primary link details, with possibly-relative URL & label.
	 *
	 * @return array|bool Array of link data, or false for no link:
	 *                    ['url' => (string) url, 'label' => (string) link text (non-escaped)]
	 */
	public function getPrimaryLink() {
		return [
			'url' => $this->event->getTitle()->getFullURL(),
			'label' => $this->msg( 'notification-commentstreams-page' )
		];
	}

	/**
	 * Get a message object and add the performer's name as
	 * a parameter. It is expected that subclasses will override
	 * this.
	 *
	 * @return Message
	 */
	public function getHeaderMessage() {
		$reply = $this->event->getExtraParam( 'reply' );
		if ( $reply ) {
			$msg = $this->msg(
				'notification-header-commentstreams-reply-on-watched-page' );
		} else {
			$msg = $this->msg(
				'notification-header-commentstreams-comment-on-watched-page' );
		}
		$msg->params( $this->event->getExtraParam(
			'comment_author_display_name' ) );
		$msg->params( $this->event->getExtraParam( 'comment_title' ) );
		$msg->params( $this->event->getExtraParam(
			'associated_page_display_title' ) );
		$msg->params( $this->event->getExtraParam(
			'comment_author_username' ) );
		$msg->params( $this->getViewingUserForGender() );
		return $msg;
	}

	/**
	 * If this function returns false, no other methods will be called
	 * on the object.
	 *
	 * @return bool
	 */
	public function canRender() {
		return !is_null( $this->event->getTitle() );
	}
}