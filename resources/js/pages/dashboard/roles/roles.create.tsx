import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/react";
import RoleForm from "./roles.form";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/roles',
    },
];



export default function CreateRole(props: any) {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Roles" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <RoleForm {...props} formType={'create'} />
            </div>
        </AppLayout >
    );
}
