import { AdminType } from "@/types/dashboard";
import { usePage } from "@inertiajs/react";


export function usePermissions() {
    const permissions = (usePage().props.auth as { user: AdminType, permissions: string[] }).permissions;

    return (ability: string) => !permissions?.includes(ability);
}
