<x-filament-widgets::widget>
    <div style="max-width: 80rem; width: 100%; margin: 0 auto; background-color: #ffffff; border-radius: 1.5rem; box-shadow: 0 4px 15px -3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; padding: 1.5rem; margin-bottom: 1.5rem; transition: all 0.3s ease;">
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Header Greeting and Status -->
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem;">
                <div>
                    <h2 style="font-size: 1.875rem; font-weight: 800; color: #0f172a; letter-spacing: -0.025em; font-family: 'Plus Jakarta Sans', sans-serif; text-transform: uppercase;">
                        Welcome Back, <span style="color: #2563eb;">Commander Dayat.</span>
                    </h2>
                    <p style="color: #64748b; font-weight: 500; margin-top: 0.25rem; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.875rem;">
                        {{ \Carbon\Carbon::now()->format('l, F jS Y') }} &mdash; Command Center Ready.
                    </p>
                </div>
                
                <!-- System Status Pill -->
                <div style="display: flex; align-items: center; gap: 0.75rem; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 0.5rem 1.25rem; border-radius: 9999px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); width: fit-content;">
                    <span style="position: relative; display: flex; width: 0.75rem; height: 0.75rem;">
                        <span style="animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite; position: absolute; display: inline-flex; height: 100%; width: 100%; border-radius: 9999px; background-color: #2563eb; opacity: 0.75;"></span>
                        <span style="position: relative; display: inline-flex; border-radius: 9999px; height: 0.75rem; width: 0.75rem; background-color: #2563eb;"></span>
                    </span>
                    <span style="font-size: 0.75rem; font-weight: 700; color: #0f172a; letter-spacing: 0.05em; text-transform: uppercase; font-family: 'Plus Jakarta Sans', sans-serif;">
                        SYSTEM SECURE / PORTFOLIO LIVE
                    </span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <!-- Projects -->
                <div style="display: flex; align-items: center; gap: 1.25rem; background-color: #ffffff; border: 1px solid #f1f5f9; border-radius: 1rem; padding: 1.25rem; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); transition: background-color 0.3s ease;">
                    <div style="background-color: #eff6ff; color: #2563eb; border-radius: 9999px; padding: 1rem;">
                        <x-heroicon-o-briefcase style="width: 2rem; height: 2rem; display: block;" />
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Total Projects</p>
                        <h3 style="font-size: 2.25rem; font-weight: 900; color: #0f172a; line-height: 1;">{{ $projectsCount ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Certifications -->
                <div style="display: flex; align-items: center; gap: 1.25rem; background-color: #ffffff; border: 1px solid #f1f5f9; border-radius: 1rem; padding: 1.25rem; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); transition: background-color 0.3s ease;">
                    <div style="background-color: #eff6ff; color: #2563eb; border-radius: 9999px; padding: 1rem;">
                        <x-heroicon-o-academic-cap style="width: 2rem; height: 2rem; display: block;" />
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">Certifications</p>
                        <h3 style="font-size: 2.25rem; font-weight: 900; color: #0f172a; line-height: 1;">{{ $certsCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
