@extends('layouts.app', [
    'activePage' => $backType ?? 'organizations_leads',
    'titlePage' => __('Organization Inactive'),
])

@section('back-btn')
    <a href="{{ route('organizations', [
            'type' => $backType ?? 'organizations_leads'
        ]) }}"
       class="home-btn-color"
       title="Back to organizations">

        {{ ($backType ?? '') === 'organizations_customers'
            ? 'BACK TO CUSTOMERS'
            : 'BACK TO LEADS' }}
    </a>
@endsection

@section('content')

<style>
    .inactive-organization-page {
        min-height: calc(100vh - 130px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px 80px;
    }

    .inactive-organization-card {
        width: 100%;
        max-width: 760px;
        background: #ffffff;
        border: 1px solid #e7e7e7;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .inactive-card-top {
        height: 7px;
        background: #d65a47;
    }

    .inactive-card-content {
        padding: 55px 45px;
        text-align: center;
    }

    .inactive-icon-wrapper {
        width: 92px;
        height: 92px;
        margin: 0 auto 25px;
        border-radius: 50%;
        background: #fff1ef;
        border: 1px solid #ffd2cc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .inactive-icon-wrapper i {
        color: #d65a47;
        font-size: 38px;
    }

    .inactive-label {
        display: inline-block;
        padding: 7px 16px;
        margin-bottom: 18px;
        border-radius: 20px;
        background: #fff1ef;
        color: #d65a47;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .inactive-title {
        margin: 0;
        color: #161617;
        font-size: 29px;
        font-weight: 700;
        line-height: 1.3;
    }

    .inactive-organization-name {
        margin-top: 10px;
        color: #717070;
        font-size: 17px;
        font-weight: 600;
        word-break: break-word;
    }

    .inactive-message {
        max-width: 550px;
        margin: 24px auto 0;
        color: #717070;
        font-size: 14px;
        line-height: 1.8;
    }

    .inactive-information-box {
        max-width: 540px;
        margin: 28px auto 0;
        padding: 18px 20px;
        background: #f8f8f8;
        border-left: 4px solid #d65a47;
        text-align: left;
    }

    .inactive-information-box p {
        margin: 0;
        color: #525252;
        font-size: 13px;
        line-height: 1.7;
    }

    .inactive-information-box strong {
        color: #161617;
    }

    .inactive-action-area {
        margin-top: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .inactive-back-button {
        min-width: 180px;
        padding: 11px 24px;
        border: 1px solid #323232;
        background: #323232;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .inactive-back-button:hover {
        background: #ffffff;
        color: #323232;
        text-decoration: none;
    }

    .inactive-status-row {
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #ededed;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        color: #989898;
        font-size: 12px;
        font-weight: 600;
    }

    .inactive-status-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #d65a47;
        box-shadow: 0 0 0 4px #fff1ef;
    }

    @media (max-width: 575px) {
        .inactive-organization-page {
            padding: 25px 12px 60px;
        }

        .inactive-card-content {
            padding: 40px 22px;
        }

        .inactive-title {
            font-size: 24px;
        }

        .inactive-back-button {
            width: 100%;
        }
    }
</style>

<div class="container-fluid inactive-organization-page">
    <div class="inactive-organization-card">

        <div class="inactive-card-top"></div>

        <div class="inactive-card-content">

            <div class="inactive-icon-wrapper">
                <i class="fas fa-building"></i>
            </div>

            <div class="inactive-label">
                Inactive Organization
            </div>

            <h1 class="inactive-title">
                This organization is currently inactive
            </h1>

            <div class="inactive-organization-name">
                {{ $organization->organization_name ?? 'Organization' }}
            </div>

            <p class="inactive-message">
                You cannot access this organization's information because the
                organization has been deactivated.
            </p>

            <div class="inactive-information-box">
                <p>
                    <strong>Need access?</strong><br>

                    Please contact an administrator and request that this
                    organization be activated. After the organization is
                    activated, you will be able to access its general
                    information, contacts, orders, payments, activities,
                    emails, and files.
                </p>
            </div>

            <div class="inactive-action-area">
                <a href="{{ route('organizations', [
                        'type' => $backType ?? 'organizations_leads'
                    ]) }}"
                   class="inactive-back-button">

                    <i class="fas fa-arrow-left mr-2"></i>

                    {{ ($backType ?? '') === 'organizations_customers'
                        ? 'Back to Customers'
                        : 'Back to Leads' }}
                </a>
            </div>

            <div class="inactive-status-row">
                <span class="inactive-status-dot"></span>
                Organization status: Inactive
            </div>

        </div>
    </div>
</div>

@endsection
