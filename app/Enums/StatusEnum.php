<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
    case Draft = 'draft';
    case Published = 'published';
    case Unpublished = 'unpublished';
    case Deleted = 'deleted';
    case Archived = 'archived';
    case Banned = 'banned';
    case Suspended = 'suspended';
    case Blocked = 'blocked';
    case Verified = 'verified';
    case Unverified = 'unverified';
    case Approved = 'approved';
    case Disapproved = 'disapproved';
    case Completed = 'completed';
    case InProgress = 'in_progress';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';
    case Failed = 'failed';
    case Expired = 'expired';
    case ActiveSubscription = 'active_subscription';
    case InactiveSubscription = 'inactive_subscription';
    case PendingSubscription = 'pending_subscription';
    case CancelledSubscription = 'cancelled_subscription';
    case ExpiredSubscription = 'expired_subscription';
    case ActiveMembership = 'active_membership';
    case InactiveMembership = 'inactive_membership';
    case PendingMembership = 'pending_membership';
    case CancelledMembership = 'cancelled_membership';
    case ExpiredMembership = 'expired_membership';
    case ActiveLicense = 'active_license';
    case InactiveLicense = 'inactive_license';
    case PendingLicense = 'pending_license';
    case CancelledLicense = 'cancelled_license';
    case ExpiredLicense = 'expired_license';
    case ActivePlan = 'active_plan';
    case InactivePlan = 'inactive_plan';
    case PendingPlan = 'pending_plan';
    case CancelledPlan = 'cancelled_plan';
    case ExpiredPlan = 'expired_plan';
    case ActiveOrder = 'active_order';
    case InactiveOrder = 'inactive_order';
    case PendingOrder = 'pending_order';
    case CancelledOrder = 'cancelled_order';
    case ExpiredOrder = 'expired_order';
    case ActiveBooking = 'active_booking';
    case InactiveBooking = 'inactive_booking';
    case PendingBooking = 'pending_booking';
    case CancelledBooking = 'cancelled_booking';
    case ExpiredBooking = 'expired_booking';
    case ActiveReservation = 'active_reservation';
    case InactiveReservation = 'inactive_reservation';
    case PendingReservation = 'pending_reservation';
    case CancelledReservation = 'cancelled_reservation';
    case ExpiredReservation = 'expired_reservation';
}
