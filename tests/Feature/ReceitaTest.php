<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Receita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class ReceitaTest extends TestCase
{
    use RefreshDatabase;

    private function criarUsuario()
    {
        return User::create([
            'nome' => 'Admin',
            'login' => 'admin',
            'password' => bcrypt('123456'),
            'situacao' => 'ativo'
        ]);
    }

    // 1
    public function test_tela_login_carrega()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // 2
    public function test_login_funciona()
    {
        $this->criarUsuario();

        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => '123456'
        ]);

        $response->assertStatus(302);
    }

    // 3
    public function test_login_invalido()
    {
        $response = $this->post('/login', [
            'login' => 'x',
            'password' => 'x'
        ]);

        $response->assertRedirect('/');
    }

    // 4
    public function test_nao_acessa_receitas_sem_login()
    {
        $response = $this->get('/receitas');
        $response->assertRedirect('/');
    }

    // 5
    public function test_acessa_receitas_logado()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)->get('/receitas');

        $response->assertStatus(200);
    }

    // 6
    public function test_criar_receita()
    {
        $user = $this->criarUsuario();

        $this->actingAs($user)->post('/receitas', [
            'nome' => 'Bolo',
            'descricao' => 'Chocolate',
            'data_registro' => '2026-01-01',
            'custo' => 20,
            'tipo_receita' => 'doce'
        ]);

        $this->assertDatabaseHas('receitas', [
            'nome' => 'Bolo'
        ]);
    }

    // 7
    public function test_editar_receita()
    {
        $user = $this->criarUsuario();

        $r = Receita::create([
            'nome' => 'Bolo',
            'descricao' => 'A',
            'data_registro' => '2026-01-01',
            'custo' => 10,
            'tipo_receita' => 'doce'
        ]);

        $this->actingAs($user)->put("/receitas/$r->id", [
            'nome' => 'Bolo Novo',
            'descricao' => 'B',
            'data_registro' => '2026-01-01',
            'custo' => 30,
            'tipo_receita' => 'salgada'
        ]);

        $this->assertDatabaseHas('receitas', [
            'nome' => 'Bolo Novo'
        ]);
    }

    // 8
    public function test_excluir_receita()
    {
        $user = $this->criarUsuario();

        $r = Receita::create([
            'nome' => 'Excluir',
            'descricao' => 'X',
            'data_registro' => '2026-01-01',
            'custo' => 10,
            'tipo_receita' => 'doce'
        ]);

        $this->actingAs($user)->delete("/receitas/$r->id");

        $this->assertDatabaseMissing('receitas', [
            'id' => $r->id
        ]);
    }

    // 9
    public function test_view_create()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)->get('/receitas/create');

        $response->assertStatus(200);
    }

    // 10
    public function test_view_edit()
    {
        $user = $this->criarUsuario();

        $r = Receita::create([
            'nome' => 'Editar',
            'descricao' => 'X',
            'data_registro' => '2026-01-01',
            'custo' => 10,
            'tipo_receita' => 'doce'
        ]);

        $response = $this->actingAs($user)->get("/receitas/$r->id/edit");

        $response->assertStatus(200);
    }

    // 11
    public function test_filtro_por_tipo()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas?tipo=doce');

        $response->assertStatus(200);
    }

    // 12
    public function test_filtro_por_data()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas?data=2026-01-01');

        $response->assertStatus(200);
    }

    // 13
    public function test_busca_por_nome()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas?busca=bolo');

        $response->assertStatus(200);
    }

    // 14
    public function test_busca_por_descricao()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas?busca=chocolate');

        $response->assertStatus(200);
    }

    // 15
    public function test_exportar_pdf()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas/pdf');

        $response->assertStatus(200);
    }

    // 16
    public function test_logout()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect('/');
    }

    // 17
    public function test_lista_receitas_carrega()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)
            ->get('/receitas');

        $response->assertSee('Receitas');
    }

    // 18
    public function test_email_criacao_fake()
    {
        Mail::fake();

        Mail::raw('teste', function ($m) {
            $m->to('teste@teste.com')->subject('teste');
        });

        Mail::assertSentCount(1); 
    }

    // 19
    public function test_redireciona_apos_criar()
    {
        $user = $this->criarUsuario();

        $response = $this->actingAs($user)->post('/receitas', [
            'nome' => 'Teste',
            'descricao' => 'X',
            'data_registro' => '2026-01-01',
            'custo' => 10,
            'tipo_receita' => 'doce'
        ]);

        $response->assertRedirect('/receitas');
    }

    // 20
    public function test_redireciona_apos_editar()
    {
        $user = $this->criarUsuario();

        $r = Receita::create([
            'nome' => 'Teste',
            'descricao' => 'X',
            'data_registro' => '2026-01-01',
            'custo' => 10,
            'tipo_receita' => 'doce'
        ]);

        $response = $this->actingAs($user)->put("/receitas/$r->id", [
            'nome' => 'Novo',
            'descricao' => 'Y',
            'data_registro' => '2026-01-01',
            'custo' => 20,
            'tipo_receita' => 'salgada'
        ]);

        $response->assertRedirect('/receitas');
    }
}
