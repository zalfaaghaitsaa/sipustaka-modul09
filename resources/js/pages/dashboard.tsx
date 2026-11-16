import { useSharedProps } from '@/hooks/use-shared-props';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { BookOpen, ClipboardList, ShieldCheck, Users } from 'lucide-react';

type DashboardProps = {
    totalBuku: number;
    totalPeminjaman: number;
    totalUsers: number | null;
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];

const cardClass = 'border-sidebar-border/70 dark:border-sidebar-border hover:bg-accent rounded-xl border p-6 transition';

export default function Dashboard({ totalBuku, totalPeminjaman, totalUsers }: DashboardProps) {
    const { user, isAdmin } = useSharedProps();

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-1 flex-col gap-4 p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border rounded-xl border p-6">
                    <h1 className="text-xl font-semibold">Selamat datang, {user.name}!</h1>
                    <p className="text-muted-foreground mt-1 flex items-center gap-2 text-sm">
                        <ShieldCheck className="size-4" />
                        Anda login sebagai {isAdmin ? 'Admin' : 'User'}.
                    </p>
                </div>

                <div className="grid gap-4 md:grid-cols-3">
                    <Link href="/buku" className={cardClass}>
                        <BookOpen className="text-muted-foreground size-6" />
                        <p className="mt-4 text-3xl font-bold">{totalBuku}</p>
                        <p className="text-muted-foreground text-sm">Jumlah buku</p>
                    </Link>

                    <Link href="/peminjaman" className={cardClass}>
                        <ClipboardList className="text-muted-foreground size-6" />
                        <p className="mt-4 text-3xl font-bold">{totalPeminjaman}</p>
                        <p className="text-muted-foreground text-sm">Jumlah peminjaman</p>
                    </Link>

                    {isAdmin && totalUsers !== null && (
                        <Link href="/admin/users" className={cardClass}>
                            <Users className="text-muted-foreground size-6" />
                            <p className="mt-4 text-3xl font-bold">{totalUsers}</p>
                            <p className="text-muted-foreground text-sm">Jumlah user</p>
                        </Link>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}