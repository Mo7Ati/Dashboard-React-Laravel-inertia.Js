import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/react";
import CategoryForm from "./categories.form";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/Categories',
    },
];

export default function EditCategory(props: any) {


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <CategoryForm {...props} formType={'edit'} />
            </div>
        </AppLayout >
    );
}
